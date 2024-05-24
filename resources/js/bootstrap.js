import axios from 'axios';

import $ from 'jquery';
import * as echarts from 'echarts';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.$=$;
window.echarts = echarts;

