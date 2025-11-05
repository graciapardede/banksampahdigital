import './bootstrap';
// Import api helper so it's included in the bundle and `window.api` is available
import './api';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
