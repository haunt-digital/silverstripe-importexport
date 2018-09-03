import Injector from 'lib/Injector';

const importExportUploadFieldReducer = (originalReducer) => (globalState) => (state, { type, payload }) => {
    switch (type) {
        case 'UPLOADFIELD_UPLOAD_SUCCESS': {
            //redirect to the generated import_url

            let redirectURL = payload.json.import_url;
            console.log(globalState);
            if (redirectURL) {
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
