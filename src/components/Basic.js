import { useContext} from 'react';
import {
    __experimentalSurface as Surface,
    __experimentalVStack as VStack,
    TextControl,
    RadioControl,
} from "@wordpress/components";
import { Container } from "@goodwp/goodenberg/admin/components";

import { __ } from "@wordpress/i18n";

import { context } from '../Context';

export default () => {
    const {data, updateData} = useContext(context);
  
    return (
        <Container contained={"800px"} as="div" hasMargin>
            <Surface style={{ padding: 20 }}>
                <VStack spacing={10}>
                    <TextControl
                        label={__("Server URL", "lifejacket-client")}
                        placeholder={__("https://example.com/wp-json/lifejacket/v1/","lifejacket-client")}
                        help={__("Provide a .org-compatible API URL. Could be a LifeJacket Server, or another implementation.", "lifejacket-client")}
                        __nextHasNoMarginBottom
                        __next40pxDefaultSize
                        value={ data.server }
                        onChange={(value)=>{ updateData( {'server': value }); }}
                        // 'server'
                    />
                    <RadioControl
                        label={__("Telemetry", "lifejacket-client")}
                        help={__("Should LifeJacket send usage stats to LifeJacket Server? If you select 'Anonymized', we'll send an md5-hashed hostname.", "lifejacket-client")}
                        selected={ data.telemetry }
                        options={[
                            { label: __("Disabled"), value: "disabled" },
                            { label: __("Anonymized"), value: "anonymized" },
                            { label: __("Enabled"), value: "enabled" },
                        ]}
                        onChange={(value)=>{ updateData( {'telemetry': value }); }}
                        // telemetry
                    />
                    {/* <div>{JSON.stringify( data )}</div> */}
                </VStack>
            </Surface>
        </Container>
    );
};