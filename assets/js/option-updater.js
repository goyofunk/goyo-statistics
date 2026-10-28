jQuery(document).ready(function () {

    if (typeof Goyo_Statistics_Option_Updater_Object === 'undefined' || !Goyo_Statistics_Option_Updater_Object) {
        return;
    }

    jQuery(document).on('click', "a.goyostats-option__updater", function (e) {
        const goyostats_object = Goyo_Statistics_Option_Updater_Object;

        e.preventDefault();

        let $this = jQuery(this);
        let option = $this.data('option');
        let value = $this.data('value');
        let params = {
            'goyostats_nonce': goyostats_object.nonce,
            'action': 'goyo_statistics_option_updater',
            'option': option,
            'value': value
        }

        $this.css('cursor', 'progress');

        jQuery.ajax({
            url: goyostats_object.admin_url + 'admin-ajax.php',
            type: 'GET',
            dataType: 'json',
            data: params,
            timeout: 30000,
            success: function ({data, success}) {
                if (!success) {
                    console.log(data);
                    $this.css('cursor', 'default');
                } else {
                    location.reload();
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
                $this.css('cursor', 'default');
            }
        });
    });
});