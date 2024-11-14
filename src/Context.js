import { createContext, useEffect, useReducer } from 'react'
import apiFetch from '@wordpress/api-fetch';

export const context = createContext();

export const OptionsProvider = ({children}) =>{
    const reducer = (state, pair) => ({ ...state, ...pair })
    const [data, updateData] = useReducer(reducer, {})

    useEffect(() =>{
        apiFetch( { path: '/lifejacket-client/v1/settings' } ).then( ( data ) => {
            updateData(data);
        } );
    },[]);

    const storeData = () => {
        return apiFetch({
            path: '/lifejacket-client/v1/settings',
            method: 'POST',
            data: data,
          });          
    }
   
   const { Provider } = context;
   
   return(
       <Provider value={{data,updateData,storeData}}>
           {children}
       </Provider>
   )
}