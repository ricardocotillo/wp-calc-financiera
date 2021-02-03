function isNumber(event: KeyboardEvent) {
  if (!/\d/.test(event.key) && event.key !== ".")
    return event.preventDefault();
}

export { isNumber }