import Injector from 'lib/Injector';

const importExportUploadFieldReducer = (originalReducer) => (globalState) => (state, { type, payload }) => {
    switch (type) {
        case 'UPLOADFIELD_UPLOAD_SUCCESS': {
            //redirect to the generated import_url

            let redirectURL = payload.json.import_url;
            console.log(globalState);
            if (redirectURL) {
                //remove changed state of the current form for redirecting without confirmation
                jQuery('#' + payload.fieldId).closest('form').removeClass('changed');
                window.location.href = redirectURL;
            }
            return originalReducer(state, { type, payload });
        }

        default: {
            return originalReducer(state, { type, payload });
        }
    }
}

Injector.transform('importExportUploaderCustom', (updater) => {
    updater.reducer('assetAdmin', importExportUploadFieldReducer);
});
