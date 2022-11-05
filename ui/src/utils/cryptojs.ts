
import CryptoJS from "crypto-js" 

const AES_KEY = "yt12an145920Yt20" // 16位
const AES_IV = "20yt029541NA21Yt" // 16位

type CryptoJsType = {
    [key: string]: Function;
}

const CryptoJs: CryptoJsType = {
    Encrypt(plainText: string) {
        var encrypted = CryptoJS.AES.encrypt(plainText, CryptoJS.enc.Utf8.parse(AES_KEY), { iv: CryptoJS.enc.Utf8.parse(AES_IV) })
        return CryptoJS.enc.Base64.stringify(encrypted.ciphertext)
    },
    Decrypt(ciphertext: string) {
        ciphertext = ciphertext.replace(/\s+/g, '+');
        var decrypted = CryptoJS.AES.decrypt(ciphertext, CryptoJS.enc.Utf8.parse(AES_KEY), { iv: CryptoJS.enc.Utf8.parse(AES_IV) })
        return decrypted.toString(CryptoJS.enc.Utf8)
    },
}

export default CryptoJs