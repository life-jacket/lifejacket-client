import ReactDOM from 'react-dom/client'

import App from './App';

import './index.css';

    
if (document.getElementById('lifejacket-client-settings')) {
    const root = ReactDOM.createRoot(document.getElementById('lifejacket-client-settings'))
    root.render( <App/> );
}