import { useContext } from "react";
import {
    __experimentalSurface as Surface,
    __experimentalVStack as VStack,
    TextControl,
    ToggleControl,
    __experimentalNumberControl as NumberControl,
} from "@wordpress/components";
import { Container } from "@goodwp/goodenberg/admin/components";
import { PasswordControl } from "./PasswordControl";

import { __ } from "@wordpress/i18n";

import { context } from '../Context';

export default () => {
    const {data, updateData} = useContext(context);
  
    return (
        <Container contained={"800px"} as="div" hasMargin>
            <Surface style={{padding: 20 }}>
                <VStack spacing={10}>
                    {/* <BaseControl label={__("Toggle Control", "wc-vienna-2024")} __nextHasNoMarginBottom __next40pxDefaultSize> */}
                        <ToggleControl
                            label={__("Require Authentication", "lifejacket-client")}
                            help={__("Only supported by LifeJacket Server", "lifejacket-client")}
                            __nextHasNoMarginBottom
                            __next40pxDefaultSize
                            checked={ data.require_auth }
                            onChange={(value)=>{ updateData( {'require_auth': value }); }}
                            // 'require_auth'
                        />
                    {/* </BaseControl> */}
                    {data.require_auth &&
                        <PasswordControl
                            label={__("Application Password for LifeJacket Server", "lifejacket-client")}
                            placeholder={__("aaaa bbbb cccc dddd eeee ffff gggg","lifejacket-client")}
                            __nextHasNoMarginBottom
                            __next40pxDefaultSize
                            autoComplete={"new-password"}
                            value={ data.application_password }
                            onChange={(value)=>{ updateData( {'application_password': value }); }}
                            //   'application_password'
                        />
                    }
                    <TextControl
                        label={__("api.wp.org Slug", "lifejacket-client")}
                        placeholder={__("api","lifejacket-client")}
                        __nextHasNoMarginBottom
                        __next40pxDefaultSize
                        value={ data.api_slug }
                        onChange={(value)=>{ updateData( {'api_slug': value }); }}
                        // 'api_slug'
                    />
                    <TextControl
                        label={__("downloads.wp.org Slug", "lifejacket-client")}
                        placeholder={__("downloads","lifejacket-client")}
                        __nextHasNoMarginBottom
                        __next40pxDefaultSize
                        value={ data.downloads_slug }
                        onChange={(value)=>{ updateData( {'downloads_slug': value }); }}
                        // 'downloads_slug'
                    />
                    {/* <div>{JSON.stringify( data )}</div> */}
                </VStack>
            </Surface>
        </Container>
    );
};