export default function shortenText(description, maxLen) {
    const marker = '...'
    return `${description.substring(0, Number(maxLen))}${marker}`
}
