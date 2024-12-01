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

import { valuesContext, sourcesContext } from '../Context';
import { Field } from './Field';

export default () => {
    const {data, updateData} = useContext(valuesContext);
    const {sources, updateSources} = useContext(sourcesContext);

    return (
        <Container contained={"800px"} as="div" hasMargin>
            <Surface style={{padding: 20 }}>
                <VStack spacing={10}>
                    {/* <BaseControl label={__("Toggle Control", "wc-vienna-2024")} __nextHasNoMarginBottom __next40pxDefaultSize> */}
                    <Field source={sources.require_auth}>
                        <ToggleControl
                            label={__("Require Authentication", "lifejacket-client")}
                            help={__("Only supported by LifeJacket Server", "lifejacket-client")}
                            __nextHasNoMarginBottom
                            __next40pxDefaultSize
                            checked={ data.require_auth ?? false }
                            onChange={(value)=>{ updateData( {'require_auth': value }); }}
                            // 'require_auth'
                        />
                    </Field>
                    {/* </BaseControl> */}
                    {data.require_auth &&
                        <Field source={sources.application_password}>
                            <PasswordControl
                                label={__("Application Password for LifeJacket Server", "lifejacket-client")}
                                placeholder={__("aaaa bbbb cccc dddd eeee ffff gggg","lifejacket-client")}
                                __nextHasNoMarginBottom
                                __next40pxDefaultSize
                                autoComplete={"new-password"}
                                value={ data.application_password ?? '' }
                                onChange={(value)=>{ updateData( {'application_password': value }); }}
                                //   'application_password'
                            />
                        </Field>
                    }
                    <Field source={sources.api_slug}>
                        <TextControl
                            label={__("api.wp.org Slug", "lifejacket-client")}
                            placeholder={__("api","lifejacket-client")}
                            __nextHasNoMarginBottom
                            __next40pxDefaultSize
                            value={ data.api_slug ?? '' }
                            onChange={(value)=>{ updateData( {'api_slug': value }); }}
                            // 'api_slug'
                        />
                    </Field>
                    <Field source={sources.downloads_slug}>
                        <TextControl
                            label={__("downloads.wp.org Slug", "lifejacket-client")}
                            placeholder={__("downloads","lifejacket-client")}
                            __nextHasNoMarginBottom
                            __next40pxDefaultSize
                            value={ data.downloads_slug ?? '' }
                            onChange={(value)=>{ updateData( {'downloads_slug': value }); }}
                            // 'downloads_slug'
                        />
                    </Field>
                </VStack>
            </Surface>
        </Container>
    );
};