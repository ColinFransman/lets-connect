const opleidingSelect = document.getElementById("opleiding");
const klasSelect = document.getElementById("klas");

const klassen = {
  opleiding1: ["Klas SIM2A", "Klas SIM2B", "Klas SIS3A", "Klas SIA3A"],
  opleiding2: ["Klas AR2MP",],
  opleiding3: ["Klas P2.1", "Klas P2.2", "Klas P2.3"],
  opleiding4: ["Klas 2ARAC",],
  opleiding5: ["Klas 2AFT", "Klas 2FC", "Klas 2FR", "Klas 2FDA", "Klas 2FDB"],
  opleiding6: ["Klas MV2A", "Klas MV2B", "Klas MV2C"],
  opleiding7: ["Klas AV3A",],
  opleiding8: ["Klas AV3B",],
  opleiding9: ["Klas IT2A", "Klas IT2B",],
  opleiding10: ["Klas MI1A", "Klas MI2A",],
  opleiding11: ["Klas SD2A", "Klas SD2B", "Klas SD2O"],
  opleiding12: ["Klas BOW2A", "Klas BOW2B", "Klas BOW2C", "Klas BOW2D", "Klas BOW2V"],
  opleiding13: ["Klas CD2A", "Klas CD2B"],
};

opleidingSelect.addEventListener("change", function() {
  
  klasSelect.innerHTML = "<option value=''>Kies een klas</option>";

  const selectedOpleiding = opleidingSelect.value;

  // Als er een opleiding is geselecteerd, vul de klas dropdown
  if (selectedOpleiding && klassen[selectedOpleiding]) {
    klassen[selectedOpleiding].forEach(function(klas) {
      const option = document.createElement("option");
      option.value = klas;
      option.textContent = klas;
      klasSelect.appendChild(option);
    });
  }
});

