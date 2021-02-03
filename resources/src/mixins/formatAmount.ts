const formatAmount = (num: Number, decimal = 0) => {
    return num.toLocaleString("es-PE", {
        style: "decimal",
        maximumFractionDigits: decimal,
        minimumFractionDigits: decimal,
    });
}

export { formatAmount }