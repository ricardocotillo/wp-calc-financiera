const formatAmount = (num, decimal = 0) => {
    return num.toLocaleString("en-US", {
        style: "decimal",
        maximumFractionDigits: decimal,
        minimumFractionDigits: decimal,
    });
}

export { formatAmount }