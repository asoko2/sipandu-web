/* Fungsi formatNominal */
function formatNominal(angka, prefix) {
  var number_string = angka.replace(/[^,\d]/g, "").toString(),
    split = number_string.split(","),
    sisa = split[0].length % 3,
    nominal = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if (ribuan) {
    separator = sisa ? "." : "";
    nominal += separator + ribuan.join(".");
  }

  nominal = split[1] != undefined ? nominal + "," + split[1] : nominal;
  return prefix == undefined ? nominal : nominal ? nominal : "";
}