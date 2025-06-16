enum SiteType {
    SITE = 'Site',
    REDE_BIBLIOTECA = 'Rede Biblioteca',
    DRABL = 'DRABL',
}

const BASE_URLS = {
    BIBLIOTECA: 'https://biblioteca-abm.madeira.gov.pt',
    ARQUIVO: 'https://arquivo-abm.madeira.gov.pt',
    DRABL: 'https://drabl.madeira.gov.pt',
    BO_DRABL: 'https://bo-drabl.madeira.gov.pt',
};

interface QuickAccessItem {
    readonly initialText: SiteType;
    readonly urlText: string;
    readonly url: string;
}

interface QuickAccess {
    readonly quickAccessItems: ReadonlyArray<QuickAccessItem>;
}

const quickAccess: QuickAccess = {
    quickAccessItems: [
        {
            initialText: SiteType.SITE,
            urlText: 'Biblioteca',
            url: `${BASE_URLS.BIBLIOTECA}/`,
        },
        {
            initialText: SiteType.SITE,
            urlText: 'Arquivo',
            url: `${BASE_URLS.ARQUIVO}/`,
        },
        {
            initialText: SiteType.SITE,
            urlText: 'DRABL',
            url: `${BASE_URLS.DRABL}/`,
        },
        {
            initialText: SiteType.REDE_BIBLIOTECA,
            urlText: 'PrismaWEB',
            url: `${BASE_URLS.BIBLIOTECA}/Prismaweb/autenticar`,
        },
        {
            initialText: SiteType.DRABL,
            urlText: 'Paínel Administração',
            url: `${BASE_URLS.BO_DRABL}/login`,
        },
    ],
};

export default quickAccess;
