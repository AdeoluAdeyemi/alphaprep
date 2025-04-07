export const decryptData = (data) => {
    const keyValue = import.meta.env.VITE_CRYPTO_SECRET_KEY
    const ivKey = import.meta.env.VITE_CRYPTO_IV_KEY


    if(data){
        const key = CryptoJS.PBKDF2(keyValue, 'salt', { keySize: 256/32, iterations:100 })
        const iv = CryptoJS.enc.Utf8.parse(ivKey)
        const decrypted = CryptoJS.AES.decrypt({ ciphertext: CryptoJS.enc.Hex.parse(data)}, key, { iv: iv, mode: CryptoJS.mode.CBC })
        return decrypted.toString(CryptoJS.enc.Utf8)
    }
}
