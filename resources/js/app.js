import './backOff'
import './bootstrap';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import focus from '@alpinejs/focus';
import {livewire_hot_reload} from 'virtual:livewire-hot-reload'
livewire_hot_reload();

window.Alpine = Alpine;

Alpine.plugin(focus);

Livewire.start()
