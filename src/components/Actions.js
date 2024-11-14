import { useContext, useState } from "react";

import { Button, Spinner } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

import { context } from '../Context';


export default () => {
    const [ processing, updateProcessing ] = useState( false );
    const {data, updateData, storeData} = useContext(context);

    return (
        <>
            {processing && <Spinner/>}
            <Button 
                variant="primary"
                disabled={processing}
                onClick={()=>{
                    updateProcessing(true);
                    storeData()
                    .then(()=>{ 
                        updateProcessing(false); 
                    });
                }}
            >
                {__("Save",'lifejacket-client')}
            </Button>
        </>
    );
}