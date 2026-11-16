import React from 'react';
import styled, { css } from 'styled-components/macro';
import tw from 'twin.macro';
import Spinner from '@/components/elements/Spinner';

interface Props {
    isLoading?: boolean;
    size?: 'xsmall' | 'small' | 'large' | 'xlarge';
    color?: 'green' | 'red' | 'primary' | 'grey';
    isSecondary?: boolean;
}

const ButtonStyle = styled.button<Omit<Props, 'isLoading'>`
    ${tw`relative inline-flex items-center justify-center rounded-xl p-2 font-bold tracking-wide text-xs uppercase transition-all duration-200 border shadow-md active:scale-95`};

    ${(props) =>
        ((!props.isSecondary && !props.color) || props.color === 'primary') &&
        css<Props>`
            ${(props) => !props.isSecondary && tw`bg-gradient-to-r from-purple-600 to-indigo-600 border-purple-500 text-white shadow-md`};

            &:hover:not(:disabled) {
                ${tw`border-purple-300 shadow-lg`};
            }
        `};

    ${(props) =>
        props.color === 'grey' &&
        css`
            ${tw`border-neutral-700 bg-neutral-800 text-neutral-200 shadow-sm`};

            &:hover:not(:disabled) {
                ${tw`bg-neutral-700 border-neutral-600 text-white shadow-md`};
            }
        `};

    ${(props) =>
        props.color === 'green' &&
        css<Props>`
            ${tw`border-green-600 bg-gradient-to-r from-green-600 to-green-500 text-white shadow-md`};

            &:hover:not(:disabled) {
                ${tw`border-green-300 shadow-lg`};
            }

            ${(props) =>
                props.isSecondary &&
                css`
                    &:active:not(:disabled) {
                        ${tw`bg-green-600 border-green-700`};
                    }
                `};
        `};

    ${(props) =>
        props.color === 'red' &&
        css<Props>`
            ${tw`border-red-600 bg-gradient-to-r from-red-600 to-red-500 text-white shadow-md`};

            &:hover:not(:disabled) {
                ${tw`border-red-300 shadow-lg`};
            }

            ${(props) =>
                props.isSecondary &&
                css`
                    &:active:not(:disabled) {
                        ${tw`bg-red-600 border-red-700`};
                    }
                `};
        `};

    ${(props) => props.size === 'xsmall' && tw`px-3 py-1.5 text-2xs rounded-lg`};
    ${(props) => (!props.size || props.size === 'small') && tw`px-4 py-2.5`};
    ${(props) => props.size === 'large' && tw`p-4 text-sm rounded-xl`};
    ${(props) => props.size === 'xlarge' && tw`p-4 w-full rounded-xl`};

    ${(props) =>
        props.isSecondary &&
        css<Props>`
            ${tw`border-neutral-800 bg-neutral-900 text-neutral-300 shadow-none`};

            &:hover:not(:disabled) {
                ${tw`border-neutral-700 bg-neutral-800 text-white`};
                ${(props) => props.color === 'red' && tw`bg-red-600 border-red-500 text-white`};
                ${(props) => props.color === 'primary' && tw`bg-purple-600 border-purple-500 text-white`};
                ${(props) => props.color === 'green' && tw`bg-green-600 border-green-500 text-white`};
            }
        `};

    &:disabled {
        opacity: 0.55;
        cursor: default;
    }
`;

type ComponentProps = Omit<JSX.IntrinsicElements['button'], 'ref' | keyof Props> & Props;

const Button: React.FC<ComponentProps> = ({ children, isLoading, ...props }) => (
    <ButtonStyle {...props}>
        {isLoading && (
            <div css={tw`flex absolute justify-center items-center w-full h-full left-0 top-0`}>
                <Spinner size={'small'} />
            </div>
        )}
        <span css={isLoading ? tw`text-transparent` : undefined}>{children}</span>
    </ButtonStyle>
);

type LinkProps = Omit<JSX.IntrinsicElements['a'], 'ref' | keyof Props> & Props;

const LinkButton: React.FC<LinkProps> = (props) => <ButtonStyle as={'a'} {...props} />;

export { LinkButton, ButtonStyle };
export default Button;
