<?php

namespace App\Filament\Support\TiptapEditor;

use Illuminate\Database\Eloquent\Model;

class Merger
{
    protected array $mergeTags;
    protected array $mergeTagsWithBraces;

    protected function __construct(Model $model)
    {
        $this->mergeTags = MergeTags::map($model);

        $this->mergeTagsWithBraces = collect($this->mergeTags)
            ->mapWithKeys(fn (?string $value, string $key) => ["{{{$key}}}" => $value])
            ->toArray();
    }

    public static function forModel(Model $model): self
    {
        return new static($model);
    }

    public static function asPlaceholders(string|array $content): string
    {
        $mergeTags = array_combine(MergeTags::$tags, array_map(fn (string $tag) => "{{ {$tag} }}", MergeTags::$tags));

        return tiptap_converter()
            ->mergeTagsMap($mergeTags)
            ->asText($content);
    }

    public function asText(string|array $content): string
    {
        $content = tiptap_converter()
            ->mergeTagsMap($this->mergeTags)
            ->asText($content);

        return str_replace(
            array_keys($this->mergeTagsWithBraces),
            array_values($this->mergeTagsWithBraces),
            $this->sanitizePlaceholders($content),
        );
    }

    protected function sanitizePlaceholders(string $content): string
    {
        return preg_replace(['/\{\{\s*/', '/\s*}}/'], ['{{', '}}'], $content);
    }

    public function asHtml(string|array $content): string
    {
        $content = tiptap_converter()
            ->mergeTagsMap($this->mergeTags)
            ->asHTML($content);

        return str_replace(
            array_keys($this->mergeTagsWithBraces),
            array_values($this->mergeTagsWithBraces),
            $this->sanitizePlaceholders($content),
        );
    }
}
