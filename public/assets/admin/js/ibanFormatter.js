function formatIban() {
    const ibanInput = document.getElementById("ibanInput");
    let inputValue = ibanInput.value.toUpperCase().replace(/\s+/g, '').replace(/[^A-Z0-9]/g, '');
    
    // IBAN numarası Türkiye formatında mı kontrolü
    const ibanIsValid = validateIban(inputValue);
    const ibanValidity = document.getElementById("ibanValidity");

    if (ibanIsValid) {
        ibanInput.classList.remove("ibanninvalid");
        ibanInput.classList.add("ibannvalid");
    } else {
        ibanInput.classList.remove("ibannvalid");
        ibanInput.classList.add("ibanninvalid");
    }

    // 4'erli gruplara ayırma
    const formattedIban = inputValue.replace(/(.{4})/g, '$1 ').trim();
    ibanInput.value = formattedIban;
}

function validateIban(iban) {
    // TR ile başlamalı ve toplam 26 karakterden oluşmalı
    if (!iban.startsWith('TR') || iban.length !== 26) {
        return false;
    }

    // Harfler sayı yerine geçmek üzere IBAN numarası çevrimi yapılır
    const rearrangedIban = iban.substring(4) + iban.substring(0, 4);
    const numericIban = rearrangedIban.replace(/[A-Z]/g, function(letter) {
        return letter.charCodeAt(0) - 55;
    });

    // Mod 97 kontrolü (uluslararası IBAN doğrulaması)
    let remainder = '';
    for (let i = 0; i < numericIban.length; i++) {
        remainder = (remainder + numericIban[i]).toString();
        remainder = (parseInt(remainder) % 97).toString();
    }

    return remainder === '1';
}