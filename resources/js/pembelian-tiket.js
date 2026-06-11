document.addEventListener("DOMContentLoaded", function () {
    const btnMinus = document.getElementById("btn-minus");
    const btnPlus = document.getElementById("btn-plus");
    const displayQty = document.getElementById("display-qty");
    const summaryLabel = document.getElementById("summary-label");
    const summaryTicketPrice = document.getElementById("summary-ticket-price");
    const summaryTotal = document.getElementById("summary-total");
    const ticketCards = document.querySelectorAll(".ticket-card");
    const inputTiketId = document.getElementById("input-tiket-id");
    const inputJumlah = document.getElementById("input-jumlah");

    let activeCard = document.querySelector(".ticket-card border-2") || ticketCards[0];
    
    // Fallback pencarian card aktif utama
    ticketCards.forEach(card => {
        if(card.querySelector(".ticket-radio").checked) {
            activeCard = card;
        }
    });

    let ticketName = activeCard ? activeCard.getAttribute("data-name") : "Tiket";
    let ticketPrice = activeCard ? parseInt(activeCard.getAttribute("data-price")) : 0;
    let qty = 1;
    const adminFee = 5000;

    function calculateTotal() {
        const subtotal = ticketPrice * qty;
        const total = subtotal + adminFee;

        summaryLabel.innerText = `Tiket ${ticketName} x${qty}`;
        summaryTicketPrice.innerText = `Rp ${subtotal.toLocaleString("id-ID")}`;
        summaryTotal.innerText = `Rp ${total.toLocaleString("id-ID")}`;
        
        // Perbarui value input hidden sebelum dikirim ke DB via Form
        inputJumlah.value = qty;
    }

    btnMinus.addEventListener("click", function () {
        if (qty > 1) {
            qty--;
            displayQty.innerText = qty;
            calculateTotal();
        }
    });

    btnPlus.addEventListener("click", function () {
        qty++;
        displayQty.innerText = qty;
        calculateTotal();
    });

    ticketCards.forEach((card) => {
        card.addEventListener("click", function () {
            const radioInput = card.querySelector(".ticket-radio");
            if (!radioInput) return;

            ticketName = card.getAttribute("data-name");
            ticketPrice = parseInt(card.getAttribute("data-price"));
            radioInput.checked = true;
            inputTiketId.value = card.getAttribute("data-id");

            ticketCards.forEach((c) => {
                c.classList.remove("border-2", "border-purple-800", "bg-purple-50/30");
                c.classList.add("border-gray-200", "bg-white");
            });

            card.classList.remove("border-gray-200", "bg-white");
            card.classList.add("border-2", "border-purple-800", "bg-purple-50/30");

            calculateTotal();
        });
    });

    // Inisialisasi awal nilai ringkasan saat halaman dimuat
    if(activeCard) {
        calculateTotal();
    }
});