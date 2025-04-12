export function formatDateToSlovenian(date) {
    if (!date) return '';
    const [year, month, day] = date.split('-');
    return `${day}.${month}.${year}`;
}

export function formatDateToISO(date) {
    if (!date) return '';
    const [day, month, year] = date.split('.');
    return `${year}-${month}-${day}`;
}
