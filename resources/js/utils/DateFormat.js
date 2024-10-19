export function dateFormat(data) {
    if(!data || data === '---') return 'Não definida'

    const partsDate = data.split('-');

    const newDate = new Date(partsDate[0], partsDate[1] - 1, partsDate[2]);

    const dia = newDate.getDate();
    const mes = newDate.getMonth() + 1;
    const ano = newDate.getFullYear();

    return (dia < 10 ? '0' : '') + dia + '/' + (mes < 10 ? '0' : '') + mes + '/' + ano;
}
