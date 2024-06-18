import Uppy from '@uppy/core';
import Dashboard from '@uppy/dashboard';
import Compressor from '@uppy/compressor';
import RemoteSources from '@uppy/remote-sources';

import '@uppy/core/dist/style.min.css';
import '@uppy/dashboard/dist/style.min.css';
import AwsS3 from "@uppy/aws-s3";

window.FomUploader = function (opt = {}) {
    const defaultOptions = {
        companionUrl: 'http://localhost:8033',
        companionAllowedHosts: [
            'http://localhost:8033'
        ],
        getUploadLinkUrl: '/file-object-manager/api/get-upload-link',
        deleteFile: '/file-object-manager/api/delete-file',
        getUploadLinkRequest: function (file) {
            return fetch(opt.getUploadLinkUrl, { // we'll send the info asynchronously via fetch to our nodejs server endpoint, '/uploader' in this case
                method: 'POST', // all the examples I found via the Uppy site used 'PUT' and did not work
                headers: {
                    'content-type': 'application/json', // examples I found via the Uppy site used 'content-type': 'application/json' and did not work
                },
                body: JSON.stringify({
                    filename: file.name, // here we are passing data to the server/back end
                    contentType: file.type,
                    size: file.size,
                    ext: file.extension.toLowerCase(),
                    metadata: {
                        'name': file.meta['name'], // here we pass the 'name' variable to the back end, with 'file.meta['name']' referring to the 'name' from our metaFields id above
                        'caption': file.meta['caption'] // here we pass the 'caption' variable to the back end, with 'file.meta['caption']' referring to the 'caption' from our metaFields id above
                    },
                })
            }).then((response) => {
                return response.json(); // return the server's response as a JSON promise
            }).then((data) => {
                console.log('>>>', data); // here you can have a look at the data the server sent back - get rid of this for production!
                const uploadInfo = data.upload_info;
                file.serverData = data.file_info;
                return {
                    method: uploadInfo.method, // here we send method, url, fields and headers to the AWS S3 bucket
                    url: uploadInfo.url,
                    fields: uploadInfo.fields,
                    headers: uploadInfo.headers,
                };
            });
        },
        uploadSuccess: function (result) {
            if (result.successful) {
                console.log('Upload complete! We’ve uploaded these files:', result.successful); // if upload succeeds, let's see what we uploaded
                const serverData = result.successful[0]['serverData'];
                FileObjectManager.showListAndSelect(serverData['id']);
            } else {
                console.log('Upload error: ', result.failed); // if upload failed, let's see what went wrong
            }
        }
    };
    opt = {
        ...defaultOptions,
        ...opt,
    };

    const sources = [
        'Url',
        'GoogleDrive'
    ];

    const uppy = new Uppy({
        allowMultipleUploads: false,
    })
        .use(Dashboard, {
            inline: true, target: '#fom-uploader',
            proudlyDisplayPoweredByUppy: false,
            showProgressDetails: true
        })
        .use(Compressor)
        .use(AwsS3, {
            fields: [],
            getUploadParameters: function (file) {
                return opt.getUploadLinkRequest(file);
            },
        }).use(RemoteSources, {
            companionUrl: opt.companionUrl,
            sources: sources,
            companionAllowedHosts: opt.companionAllowedHosts,
        });

    uppy.on('complete', (result) => {
        opt.uploadSuccess(result);
    })

    uppy.on('file-removed', (file, reason) => {
        console.log('Removed file', file);

        return fetch(opt.deleteFile, { // we'll send the info asynchronously via fetch to our nodejs server endpoint, '/uploader' in this case
            method: 'POST', // all the examples I found via the Uppy site used 'PUT' and did not work
            headers: {
                'content-type': 'application/json', // examples I found via the Uppy site used 'content-type': 'application/json' and did not work
            },
            body: JSON.stringify(file.serverData)
        }).then((response) => {
            return response.json(); // return the server's response as a JSON promise
        }).then((data) => {
            console.log('Removed data >>>', data); // here you can have a look at the data the server sent back - get rid of this for production!
        });
    });

    return {};
}
