import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import * as bootstrap from 'bootstrap';

import $ from 'jquery';
window.$=$;

import * as echarts from 'echarts';
window.echarts = echarts;

import moment from 'moment';
window.moment = moment; // 将Moment.js绑定到全局对象，以便DateTimePicker能够访问
import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css';
import 'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js';
