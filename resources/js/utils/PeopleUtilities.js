

export default async function WhatIsGender(nome) {
    try {
        const response = await fetch(`https://api.genderize.io?name=${nome}`);
        const data = await response.json();
        if (data.gender) {
            return data.gender
        }
        console.log(  data.gender);
    } catch (error) {
        console.error('Erro ao acessar a API Genderize:', error);
    }
    return null
}
