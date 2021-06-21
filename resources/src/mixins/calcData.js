const baseUrl = "/wp-content/plugins/wp-calc-financiera/public"
const initialMsg = "La simulación de la cuota y el cronograma puede variar según tu evaluación."
const msgs = {
  0: "Las cuotas incluyen interés y amortización . La simulación de la cuota y el cronograma puede variar según tu evaluación.",
  1: "Las cuotas no incluyen amortización , reembolsas el capital a tu ritmo. La simulación de la cuota y el cronograma puede variar según tu evaluación.",
  2: "No hay cuotas mensuales, todo se paga al finalizar el plazo. La simulación de la cuota y el cronograma puede variar según tu evaluación.",
};
const typeOfPayments = [
  { key: 1, title: "Cuotas fijas" },
  { key: 2, title: "Sólo intereses" },
  { key: 3, title: "Préstamo puente" },
];
const periods = {
  0: [
    { key: 1, title: "1 año" },
    { key: 2, title: "2 años" },
    { key: 3, title: "3 años" },
    { key: 4, title: "4 años" },
    { key: 5, title: "5 años" },
  ],
  1: [{ key: 1, title: "1 año" }],
  2: [{ key: 1, title: "1 año" }],
};

export { initialMsg, msgs, typeOfPayments, periods, baseUrl }