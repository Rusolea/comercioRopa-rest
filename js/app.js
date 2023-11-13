"use strict"
console.log('Hola desde app.js');

const URL = "api/products/";
//console.log(URL); mostrar la url en consola si funciona
console.log(URL);

let productss = [];

let form = document.querySelector('#products-form');
form.addEventListener('submit', insertproducts);


/**
 * Obtiene todas los productss via API REST
 */


async function getAll() {
    try {
        let response = await fetch(URL);
        if (!response.ok) {
            throw new Error('Recurso no existe');
        }
        productss = await response.json();

        showproductss();
    } catch(e) {
        console.log(e);
    }
}

/**
 * Inserta la tarea via API REST
 */
async function insertproducts(e) {
    e.preventDefault();
    
    let data = new FormData(form);
    let products = {
        titulo: data.get('titulo'),
        descripcion: data.get('descripcion'),
        prioridad: data.get('prioridad'),
    };

    try {
        let response = await fetch(URL, {
            method: "POST",
            headers: { 'Content-Type': 'application/json'},
            body: JSON.stringify(products)
        });
        if (!response.ok) {
            throw new Error('Error del servidor');
        }

        let nproducts = await response.json();

        // inserto la tarea nuevo
        productss.push(nproducts);
        showproductss();

        form.reset();
    } catch(e) {
        console.log(e);
    }
} 

async function deleteproducts(e) {
    e.preventDefault();
    try {
        let id = e.target.dataset.products;
        let response = await fetch(URL + id, {method: 'DELETE'});
        if (!response.ok) {
            throw new Error('Recurso no existe');
        }

        // eliminar la tarea del arreglo global
        productss = productss.filter(products => products.id != id);
        showproductss();
    } catch(e) {
        console.log(e);
    }
}

async function finalizeproducts(e) {
    e.preventDefault();
    alert('El finalizar le toca a ustedes :)')
}

function showproductss() {
    let ul = document.querySelector("#products-list");
    ul.innerHTML = "";
    for (const products of productss) {

        let html = `
            <li class='
                    list-group-item d-flex justify-content-between align-items-center
                    ${ products.finalizada == 1 ? 'finalizada' : ''}
                '>
                <span> <b>${products.titulo}</b> - ${products.descripcion} (prioridad ${products.prioridad}) </span>
                <div class="ml-auto">
                    ${products.finalizada != 1 ? `<a href='#' data-products="${products.id}" type='button' class='btn btn-success btn-finalize'>Finalizar</a>` : ''}
                    <a href='#' data-products="${products.id}" type='button' class='btn btn-danger btn-delete'>Borrar</a>
                </div>
            </li>
        `;

        ul.innerHTML += html;
    }

    // asigno event listener para los botones
    const btnsDelete = document.querySelectorAll('a.btn-delete');
    for (const btnDelete of btnsDelete) {
        btnDelete.addEventListener('click', deleteproducts);
    }

    const btnsFinalizar = document.querySelectorAll('a.btn-finalize');
    for (const btnFinalizar of btnsFinalizar) {
        btnFinalizar.addEventListener('click', finalizeproducts);
    }
}

getAll();
