function formatRub(n) {
  const sign = n < 0 ? "-" : "";
  const abs = Math.abs(n);
  return `${sign}₽${abs.toLocaleString("ru-RU")}`;
}

const cards = Array.from(document.querySelectorAll(".card"));
let income = 0;
let expense = 0;

for (const card of cards) {
  const rent = Number(card.dataset.rent || 0);
  const mortgage = Number(card.dataset.mortgage || 0);
  const net = rent - mortgage;

  income += rent;
  expense += mortgage;

  const netEl = card.querySelector("[data-net]");
  const badgeEl = card.querySelector("[data-badge]");

  netEl.textContent = formatRub(net);
  netEl.classList.toggle("money__net--pos", net >= 0);
  netEl.classList.toggle("money__net--neg", net < 0);

  if (net >= 0) {
    badgeEl.textContent = "Плюс";
    badgeEl.classList.add("badge--pos");
  } else {
    badgeEl.textContent = "Минус";
    badgeEl.classList.add("badge--neg");
  }
}

const netTotal = income - expense;

document.getElementById("kpiIncome").textContent = formatRub(income);
document.getElementById("kpiExpense").textContent = formatRub(expense);
document.getElementById("kpiNet").textContent = formatRub(netTotal);
document.getElementById("kpiHint").textContent =
  netTotal > 0
    ? "Портфель в плюсе"
    : netTotal < 0
    ? "Портфель в минусе"
    : "Портфель в нуле";
