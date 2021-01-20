function isNumber(event) {
  if (!/\d/.test(event.key) && event.key !== ".")
    return event.preventDefault();
}

export { isNumber }