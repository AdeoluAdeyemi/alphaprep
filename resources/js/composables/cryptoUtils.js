import CryptoJS from 'crypto-js';

export const decrypt = (data) => {
    // Cipher method
    const algorithm = 'AES';

    const iv = CryptoJS.enc.Utf8.parse(import.meta.env.VITE_CRYPTO_IV_KEY);
    const key = CryptoJS.enc.Utf8.parse(import.meta.env.VITE_CRYPTO_SECRET_KEY); // 16 bytes key

    if(data) {
        const ciphertext = CryptoJS.enc.Base64.parse(data)

        const decrypted = CryptoJS.AES.decrypt(
            {ciphertext: ciphertext},
            key,
            { iv: iv, mode: CryptoJS.mode.CTR, padding: CryptoJS.pad.NoPadding }
        );

        return decrypted.toString(CryptoJS.enc.Utf8)
    }
}

export const encrypt = (data) => {
    const iv = CryptoJS.enc.Utf8.parse(import.meta.env.VITE_CRYPTO_IV_KEY);
    const key = CryptoJS.enc.Utf8.parse(import.meta.env.VITE_CRYPTO_SECRET_KEY); // 16 bytes key

    //return encrypted.ciphertext.toString(CryptoJS.enc.Hex)

    const encrypted = CryptoJS.AES.encrypt(data, key, { iv: iv, mode: CryptoJS.mode.CTR, padding: CryptoJS.pad.NoPadding });
    return encrypted.toString(CryptoJS.enc.Hex) //encrypted.toString();

}
