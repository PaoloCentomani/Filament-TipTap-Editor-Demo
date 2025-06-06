import preset
    from '../../../../vendor/filament/filament/tailwind.config.preset';

export default {
    presets: [preset],
    content: [
        './app/Filament/Admin/**/*.php',
        './resources/views/filament/admin/**/*.blade.php',
        './resources/views/filament/tiptap-editor/blocks/**/*.blade.php',
        './resources/views/livewire/email-template/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
};
