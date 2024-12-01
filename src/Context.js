import { createContext, useEffect, useReducer } from 'react'
import apiFetch from '@wordpress/api-fetch';

export const valuesContext = createContext();
export const sourcesContext = createContext();

export const OptionsProvider = ({children}) =>{
    const dataReducer = (state, pair) => ({ ...state, ...pair })
    const [data, updateData] = useReducer(dataReducer, {})

    useEffect(() =>{
        apiFetch( { path: '/lifejacket-client/v1/settings' } ).then( ( data ) => {
            updateData(data.values);
        } );
    },[]);

    const storeData = () => {
        return apiFetch({
            path: '/lifejacket-client/v1/settings',
            method: 'POST',
            data: data,
          });          
    }
   
   const { Provider } = valuesContext;
   
   return(
        <Provider value={{data,updateData,storeData}}>
            {children}
        </Provider>
   )
}

export const SourcesProvider = ({children}) =>{
    const sourcesReducer = (state, pair) => ({ ...state, ...pair })
    const [sources, updateSources] = useReducer(sourcesReducer, {})

    useEffect(() =>{
        apiFetch( { path: '/lifejacket-client/v1/settings' } ).then( ( data ) => {
            updateSources(data.sources);
        } );
    },[]);

   const { Provider } = sourcesContext;
   
   return(
        <Provider value={{sources,updateSources}}>
            {children}
        </Provider>
   )
}