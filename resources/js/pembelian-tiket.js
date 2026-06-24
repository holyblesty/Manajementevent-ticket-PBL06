const plusBtn = document.getElementById("plusBtn");
const minusBtn = document.getElementById("minusBtn");

const qty = document.getElementById("qty");

const totalPrice = document.getElementById("totalPrice");

const ticketPrice = document.getElementById("ticketPrice");

let jumlah = 1;

// HARGA TIKET
let harga = 150000;

// BIAYA LAYANAN
let layanan = 5000;

/**
 * FORMAT RUPIAH
 */
function formatRupiah(angka)
{
    return "Rp " + angka.toLocaleString("id-ID");
}

/**
 * UPDATE TOTAL HARGA
 */
function updateTotal()
{
    let total = (harga * jumlah) + layanan;

    // UPDATE JUMLAH
    qty.innerText = jumlah;

    // UPDATE TOTAL
    totalPrice.innerText = formatRupiah(total);

    // UPDATE HARGA TIKET
    ticketPrice.innerText =
        formatRupiah(harga * jumlah);
}

/**
 * TOMBOL TAMBAH
 */
plusBtn.addEventListener("click", () =>
{
    jumlah++;

    updateTotal();
});

/**
 * TOMBOL KURANG
 */
minusBtn.addEventListener("click", () =>
{
    if(jumlah > 1)
    {
        jumlah--;

        updateTotal();
    }
});

/**
 * LOAD PERTAMA
 */
updateTotal();