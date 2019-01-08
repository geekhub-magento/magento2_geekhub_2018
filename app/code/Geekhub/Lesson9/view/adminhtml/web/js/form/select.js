define([
    'underscore',
    'Magento_Ui/js/form/element/abstract',
    'uiRegistry'
], function (_, Input, registry) {
    'use strict';

    return Input.extend({
        defaults: {
            listens: {
                value: 'showAlert'
            },
            modules: {
                job: 'cron_job_form.cron_job_form.general.job_code'
            }
        },

        showAlert: function (value) {
            var job = registry.get('cron_job_form.cron_job_form.general.job_code');
            if (value == 1) {
                job.disabled(true);
            } else {
                job.disabled(false);
            }
        }
    });
});