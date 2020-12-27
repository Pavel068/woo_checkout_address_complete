/*
* Settings
* */

const address_selector_name = '#billing_address_1';
const fields_selectors = {
    address_1: '#billing_address_1',
    city: '#billing_city',
    state: '#billing_state',
    postcode: '#billing_postcode',
}

/*  */
let autocomplete;

function initialize() {
    autocomplete = new google.maps.places.Autocomplete(document.querySelector(address_selector_name), {
        types: ['geocode']
    });

    google.maps.event.addListener(autocomplete, 'place_changed', () => {
        fillAddress();
    })
}

function completeFields(place_components) {
    Object.keys(place_components).forEach(key => {
        try {
            document.querySelector(fields_selectors[key]).value = place_components[key];
        } catch (e) {
            console.warn(e);
        }
    });
}

function fillAddress() {
    let place = autocomplete.getPlace();

    let place_components = {
        address_1: null,
        city: null,
        state: null,
        postcode: null,
    }

    if (place.address_components) {
        place.address_components.forEach(component => {
            if (component.types.indexOf('street_number') !== -1) {
                place_components.address_1 = component.short_name;
            }

            if (component.types.indexOf('route') !== -1) {
                if (place_components.address_1) {
                    place_components.address_1 += ' ' + component.short_name;
                } else {
                    place_components.address_1 = component.short_name;
                }
            }

            if (component.types.indexOf('locality') !== -1) {
                place_components.city = component.short_name;
            }

            if (component.types.indexOf('administrative_area_level_1') !== -1) {
                place_components.state = component.short_name;
            }

            if (component.types.indexOf('postal_code') !== -1) {
                place_components.postcode = component.short_name;
            }
        });

        completeFields(place_components);
    }
}