import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
import * as bootstrap from 'bootstrap';

import * as echarts from 'echarts';
window.echarts = echarts;
