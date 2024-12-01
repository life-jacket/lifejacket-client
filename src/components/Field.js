import { Notice } from '@wordpress/components';
import React from 'react';

export const Field = ({ children, source }) => {
    const ProxyProps = ( children, props  ) => {
        return React.cloneElement(children, {
            ...props,
        });
    }

    const disabled = ['constant','network'].includes( source );

    return (
        <div>
            {ProxyProps(children, { disabled } )}
            {disabled && <Notice status="info" isDismissible={false}>This option has been defined in <code>{source}</code> context. Remove the setting there to make it editable here.</Notice>}
        </div>
    )
}