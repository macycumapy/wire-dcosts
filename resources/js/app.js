import './bootstrap';
// import './back-off'
import './wire-navigate'

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import focus from '@alpinejs/focus';
import {livewire_hot_reload} from 'virtual:livewire-hot-reload'
import Tooltip from "@ryangjchandler/alpine-tooltip";
import * as Filepond from "filepond";
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import Pikaday from 'pikaday'
import moment from 'moment'

Filepond.registerPlugin(FilePondPluginFileValidateSize);
Filepond.registerPlugin(FilePondPluginFileValidateType);
livewire_hot_reload();

window.Alpine = Alpine;
window.Filepond = Filepond;
window.Pikaday = Pikaday;
window.moment = moment;

Alpine.plugin(focus);
Alpine.plugin(Tooltip);

Livewire.start()
