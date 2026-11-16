import styled from 'styled-components/macro';
import tw from 'twin.macro';

export default styled.div<{ $hoverable?: boolean }>`
    ${tw`flex rounded-2xl no-underline text-neutral-200 items-center bg-[#0d1222] p-4 border border-neutral-800 transition-all duration-200 shadow-md overflow-hidden`};

    ${(props) => props.$hoverable !== false && tw`hover:border-purple-500 hover:bg-[#11182d] hover:shadow-lg hover:-translate-y-0.5`};

    & .icon {
        ${tw`rounded-xl w-14 h-14 flex items-center justify-center bg-purple-900 text-purple-400 border border-purple-700 p-3`};
    }
`;
