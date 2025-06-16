const STORAGE_BASE_PATH = '/storage/images';

interface ImagePaths {
    readonly logo: string;
    readonly background: string;
}

export const imagePaths: ImagePaths = {
    logo: `${STORAGE_BASE_PATH}/logo-wisi-small.png`,
    background: `${STORAGE_BASE_PATH}/background_deposit.jpg`,
};
