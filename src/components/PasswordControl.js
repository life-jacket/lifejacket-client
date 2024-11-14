import { seen, unseen } from '@wordpress/icons';
import { useState } from '@wordpress/element';

import { 
    Button,
    __experimentalInputControl as InputControl, 
    __experimentalInputControlPrefixWrapper as InputControlPrefixWrapper,
    __experimentalInputControlSuffixWrapper as InputControlSuffixWrapper,
} from '@wordpress/components';

export const PasswordControl = (args) => {
    const [ visible, setVisible ] = useState( false );
    // return (<InputControl type={"text"} value={"aaa"}/> );
    return (
        <InputControl
            type={ visible ? 'text' : 'password' }
            label="Password"
            suffix={
                <InputControlSuffixWrapper>
                    <div style={ { display: 'flex' } }>
                        <Button
                            size="small"
                            icon={ visible ? unseen : seen }
                            onClick={ () => setVisible( ( value ) => ! value ) }
                            label={
                                visible ? 'Hide password' : 'Show password'
                            }
                        />
                    </div>
                </InputControlSuffixWrapper>
            }
            { ...args }
        />
    );    
}
