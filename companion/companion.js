import express from 'express';
import bodyParser from 'body-parser';
import session from 'express-session';
import companion from '@uppy/companion';
import dotenv from 'dotenv';

dotenv.config({
    path: '../.env'
});

const app = express();

// Companion requires body-parser and express-session middleware.
// You can add it like this if you use those throughout your app.
//
// If you are using something else in your app, you can add these
// middlewares in the same subpath as Companion instead.
app.use(bodyParser.json());
app.use(session({ secret: process.env.COMPANION_SESSION_SECRET }));

const port = process.env.COMPANION_PORT || 1234;

const companionOptions = {
    secret: process.env.COMPANION_SECRET,
    providerOptions: {
        drive: {
            key: process.env.COMPANION_GOOGLE_KEY,
            secret: process.env.COMPANION_GOOGLE_SECRET,
        },
    },
    server: {
        host: process.env.COMPANION_DOMAIN,
        implicitPath: process.env.COMPANION_IMPLICIT_PATH,
        protocol: process.env.COMPANION_SERVER_PROTOCOL,
        // path: '/file-object-manager/companion'
        // Default installations normally don't need a path.
        // However if you specify a `path`, you MUST specify
        // the same path in `app.use()` below,
        // e.g. app.use('/companion', companionApp)
        // path: '/companion',
    },
    filePath: process.env.COMPANION_TEMP_DOWNLOAD_FOLDER,
    uploadUrls: ['.+']
};

const { app: companionApp } = companion.app(companionOptions);
app.use(companionApp);

const server = app.listen(port);
console.log(`Companion is listening on PORT ${port}`)
companion.socket(server);
