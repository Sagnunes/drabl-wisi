enum ObjectStatus {
    noASSOCIATION = 0,
    ASSOCIATED = 1,
    PUBLISHED = 2,
}

export function getStatusName(status: ObjectStatus): string {
    switch (status) {
        case ObjectStatus.noASSOCIATION:
            return "Sem associação";
        case ObjectStatus.ASSOCIATED:
            return "Não Publicado";
        case ObjectStatus.PUBLISHED:
            return "Publicado";
        default:
            return "Erro.";
    }
}
export default ObjectStatus;
