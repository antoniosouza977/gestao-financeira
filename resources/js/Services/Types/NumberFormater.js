class NumberFormater {
    toLocalCurrency(float) {
        return  new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL',
        }).format(float);
    }
}

export default new NumberFormater();
