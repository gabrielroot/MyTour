import $ from 'jquery';
import Swal from 'sweetalert2';

// Coordenadas iniciais
const initialLatLng = [-23.55052, -46.633308] // São Paulo

// Cria o mapa
const map = L.map('map').setView(initialLatLng, 15)

// Tile layer OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
}).addTo(map)

// Marcador central
const marker = L.marker(initialLatLng).addTo(map)

// Atualiza coords quando o mapa parar de mover
map.on('moveend', () => {
    const center = map.getCenter()

    marker.setLatLng(center)

    const lat = center.lat.toFixed(6)
    const long = center.lng.toFixed(6)

    $('#checkpoint_latitude').val(lat)
    $('#checkpoint_longitude').val(long)

    $('#coords').html(`Lat: ${lat} | Lng: ${long}`)
})

let debounceTimer = null
$('#checkpoint_location').keyup(function () {
    clearTimeout(debounceTimer)

    debounceTimer = setTimeout(() => {
        const value = $(this).val()

        if (!value.trim()) return

        searchLocation(value)
    }, 2000) // 500ms depois da última tecla
})

async function searchLocation(value) {
    const url = `${searchAddressEndpoint}?q=${encodeURIComponent(value)}`

    const response = await fetch(url)
    const data = await response.json()

    if (!data.length) {
        Swal.fire({
            title: "Não encontrado",
            text: "O local que você inseriu não foi encontrado.",
            icon: "info",
            confirmButtonText: "Certo"
        })
        $('#coords').html('Local não encontrado.')
        return
    }

    const { lat, lon } = data[0]

    $('#checkpoint_longitude').val(lon)
    $('#checkpoint_latitude').val(lat)

    map.setView([lat, lon], 13)
    marker.setLatLng([lat, lon])
}