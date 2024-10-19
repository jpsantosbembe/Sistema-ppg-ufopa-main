// third-party
import { add, sub } from 'date-fns';
import { Chance } from 'chance';
//Types
import type { Address } from '@/Types/apps/EcommerceType';

const chance = new Chance();

// billing address list
let address: Address[] = [
    {
        id: 1,
        name: chance.name(),
        destination: 'Home',
        building: chance.address({ short_suffix: true }),
        city: chance.city(),
        state: chance.state({ full: true }),
        phone: chance.phone(),
        isDefault: true
    },
    {
        id: 2,
        name: chance.name(),
        destination: 'Office',
        building: chance.address({ short_suffix: true }),
        city: chance.city(),
        state: chance.state({ full: true }),
        phone: chance.phone(),
        isDefault: false
    },
    {
        id: 3,
        name: chance.name(),
        destination: 'Office',
        building: chance.address({ short_suffix: true }),
        city: chance.city(),
        state: chance.state({ full: true }),
        phone: chance.phone(),
        isDefault: false
    }
];

// ==============================|| MOCK SERVICES ||============================== //

export {address}
