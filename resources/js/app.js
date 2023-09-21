import './backOff'
import './bootstrap';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import focus from '@alpinejs/focus';
import {livewire_hot_reload} from 'virtual:livewire-hot-reload'
import * as Filepond from "filepond";
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';

Filepond.registerPlugin(FilePondPluginFileValidateSize);
Filepond.registerPlugin(FilePondPluginFileValidateType);
livewire_hot_reload();

window.Alpine = Alpine;
window.Filepond = Filepond;

Alpine.plugin(focus);

Livewire.start()
