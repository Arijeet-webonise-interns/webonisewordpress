function include_media_button_js_file() {
    wp_enqueue_script('media_button', 'path/to/media_button.js', array('jquery'), '1.0', true);
}
jQuery(function($) {
    $(document).ready(function(){
        $('#insert-my-media').click(function(){
            if (this.window === undefined) {
                wp.media.editor.insert('[mcp-party-list]');
            }

            this.window.open();
            return false;
        });
    });
});