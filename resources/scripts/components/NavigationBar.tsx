import * as React from 'react';
import { useState, useEffect } from 'react';
import { Link, NavLink, useRouteMatch, useLocation } from 'react-router-dom';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {
    faCogs,
    faCubes,
    faPaintBrush,
    faUserPlus,
    faLink,
    faTicketAlt,
    faWrench,
    faCloudUploadAlt,
    faChevronDown,
    faChevronRight,
    faLayerGroup,
    faSignOutAlt,
    faBars,
    faTimes,
    faUser,
    faBell,
    faBullhorn,
    faSun,
    faMoon,
    faHeadset,
    faTerminal,
    faFolderOpen,
    faDatabase,
    faCalendarAlt,
    faUsers,
    faArchive,
    faNetworkWired,
    faPlay,
    faSlidersH,
    faHistory,
    faExternalLinkAlt,
    faGlobe,
    faPuzzlePiece,
    faDownload
} from '@fortawesome/free-solid-svg-icons';
import { useStoreState } from 'easy-peasy';
import { ApplicationStore } from '@/state';
import SearchContainer from '@/components/dashboard/search/SearchContainer';
import getAnnouncements, { Announcement } from '@/api/getAnnouncements';
import NotificationDrawer from '@/components/dashboard/NotificationDrawer';
import tw, { theme } from 'twin.macro';
import styled from 'styled-components/macro';
import http from '@/api/http';
import SpinnerOverlay from '@/components/elements/SpinnerOverlay';
import { ServerContext } from '@/state/server';
import routes from '@/routers/routes';
import Can from '@/components/elements/Can';
import { Dialog } from '@/components/elements/dialog';

const SidebarLink = styled(NavLink)`
    ${tw`flex items-center w-full px-3.5 py-2.5 text-neutral-400 hover:text-white hover:bg-neutral-800 rounded-xl transition-all duration-150 no-underline font-medium text-sm`};
    &.active {
        ${tw`text-white bg-gradient-to-r from-purple-600 to-indigo-600 shadow-md font-semibold border-l-4 border-purple-300`};
    }
`;

const SidebarAnchor = styled.a`
    ${tw`flex items-center w-full px-3.5 py-2.5 text-neutral-400 hover:text-white hover:bg-neutral-800 rounded-xl transition-all duration-150 no-underline font-medium text-sm`};
`;

const SidebarButton = styled.button`
    ${tw`flex items-center w-full px-3.5 py-2.5 text-neutral-400 hover:text-red-400 hover:bg-red-500/10 rounded-xl transition-all duration-150 text-left font-medium text-sm`};
`;

const iconMap: Record<string, any> = {
    'Console': faTerminal,
    'Files': faFolderOpen,
    'Databases': faDatabase,
    'Schedules': faCalendarAlt,
    'Users': faUsers,
    'Backups': faArchive,
    'Network': faNetworkWired,
    'Startup': faPlay,
    'Settings': faSlidersH,
    'Activity': faHistory,
    'Subdomains': faGlobe,
    'Plugins': faPuzzlePiece,
    'Versions': faDownload,
};

const ServerSidebarLinks = ({ setSidebarOpen }: { setSidebarOpen: (o: boolean) => void }) => {
    const match = useRouteMatch<{ id: string }>('/server/:id');
    const rootAdmin = useStoreState((state: ApplicationStore) => state.user.data!.rootAdmin);

    if (!match) return null;

    return <ServerSidebarLinksInner match={match} rootAdmin={rootAdmin} setSidebarOpen={setSidebarOpen} />;
};

const ServerSidebarLinksInner = ({ match, rootAdmin, setSidebarOpen }: { match: any, rootAdmin: boolean, setSidebarOpen: (o: boolean) => void }) => {
    const serverName = ServerContext.useStoreState((state) => state.server.data?.name);
    const serverId = ServerContext.useStoreState((state) => state.server.data?.internalId);
    const nestId = ServerContext.useStoreState((state) => state.server.data?.nestId);

    const pluginsConfig = (window as any).SiteConfiguration?.plugins;
    const isPluginsEnabled = !!(pluginsConfig?.enabled && nestId && pluginsConfig?.nests?.includes(nestId));

    const versionsConfig = (window as any).SiteConfiguration?.versions;
    const isVersionsEnabled = !!(versionsConfig?.enabled && nestId && versionsConfig?.nests?.includes(nestId));

    const to = (path: string) => {
        if (path === '/') {
            return `/server/${match.params.id}`;
        }
        return `/server/${match.params.id}/${path.replace(/^\/+/, '')}`;
    };

    return (
        <>
            <div className="h-px bg-neutral-800 my-4" />
            <div className="text-[10px] font-bold text-neutral-500 px-4 pb-2 tracking-wider uppercase truncate" title={serverName}>
                {serverName || 'Server Management'}
            </div>
            {routes.server
                .filter((route) => {
                    if (route.path === '/plugins') {
                        return isPluginsEnabled;
                    }
                    if (route.path === '/versions') {
                        return isVersionsEnabled;
                    }
                    return !!route.name;
                })
                .map((route) => {
                    const icon = iconMap[route.name!] || faLayerGroup;
                    const content = (
                        <SidebarLink
                            key={route.path}
                            to={to(route.path)}
                            exact={route.exact}
                            onClick={() => setSidebarOpen(false)}
                        >
                            <FontAwesomeIcon icon={icon} css={tw`w-5 mr-4 text-center`} />
                            <span>{route.name}</span>
                        </SidebarLink>
                    );

                    return route.permission ? (
                        <Can key={route.path} action={route.permission} matchAny>
                            {content}
                        </Can>
                    ) : (
                        content
                    );
                })}

        </>
    );
};

export default () => {
    const [announcements, setAnnouncements] = useState<Announcement[]>([]);
    const [notificationOpen, setNotificationOpen] = useState(false);
    const [readIds, setReadIds] = useState<number[]>(() => {
        try {
            const saved = localStorage.getItem('ptero_read_announcements');
            return saved ? JSON.parse(saved) : [];
        } catch {
            return [];
        }
    });

    useEffect(() => {
        getAnnouncements()
            .then((data) => setAnnouncements(Array.isArray(data) ? data : []))
            .catch(() => setAnnouncements([]));

        const interval = setInterval(() => {
            getAnnouncements()
                .then((data) => setAnnouncements(Array.isArray(data) ? data : []))
                .catch(() => {});
        }, 60000);

        return () => clearInterval(interval);
    }, []);

    const handleMarkAllRead = () => {
        const allIds = (announcements || []).map((a) => a.id);
        setReadIds(allIds);
        try {
            localStorage.setItem('ptero_read_announcements', JSON.stringify(allIds));
        } catch {}
    };

    const handleMarkRead = (id: number) => {
        if (!readIds.includes(id)) {
            const next = [...readIds, id];
            setReadIds(next);
            try {
                localStorage.setItem('ptero_read_announcements', JSON.stringify(next));
            } catch {}
        }
    };

    const unreadCount = (announcements || []).filter((a) => !readIds.includes(a.id)).length;
    const location = useLocation();
    const name = useStoreState((state: ApplicationStore) => state.settings.data!.name);
    const rootAdmin = useStoreState((state: ApplicationStore) => state.user.data!.rootAdmin);
    const discordUrl = (useStoreState((state: ApplicationStore) => state.settings.data!.theme?.discord_url) || '').trim() || 'https://discord.gg';
    const ticketsConfig = (window as any).SiteConfiguration?.tickets;
    const isTicketsEnabled = !!(ticketsConfig?.enabled ?? true);
    const [isLoggingOut, setIsLoggingOut] = useState(false);
    const [confirmLogout, setConfirmLogout] = useState(false);
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [pluginsOpen, setPluginsOpen] = useState(false);

    useEffect(() => {
        document.body.classList.remove('light-mode');
        document.documentElement.classList.remove('light-mode');
        localStorage.removeItem('theme');
    }, []);

    const onTriggerLogout = () => {
        setConfirmLogout(true);
    };

    const handleLogout = () => {
        setConfirmLogout(false);
        setIsLoggingOut(true);
        http.post('/auth/logout').finally(() => {
            // @ts-expect-error this is valid
            window.location = '/';
        });
    };

    const DiscordIcon = () => (
        <svg viewBox="0 0 127.14 96.36" style={{ width: '18px', height: '18px', fill: 'currentColor' }}>
            <path d="M107.7,8.07A105.15,105.15,0,0,0,77.26,0a77.19,77.19,0,0,0-3.3,6.83A96.67,96.67,0,0,0,53.22,6.83,77.19,77.19,0,0,0,49.88,0,105.15,105.15,0,0,0,19.44,8.07C3.66,31.58-1.86,54.65,1,77.53A105.73,105.73,0,0,0,32,96.36a77.7,77.7,0,0,0,6.63-10.85,68.43,68.43,0,0,1-10.43-5c.87-.64,1.71-1.32,2.51-2a76.1,76.1,0,0,0,72.76,0c.8,0.7,1.64,1.38,2.51,2a68.43,68.43,0,0,1-10.43,5,77.7,77.7,0,0,0,6.63,10.85,105.73,105.73,0,0,0,31-18.83C129.87,50.22,123.63,27.31,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53S36.18,40.36,42.45,40.36,53.83,46,53.83,53,48.72,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.24,60,73.24,53S78.41,40.36,84.69,40.36,96.07,46,96.07,53,91,65.69,84.69,65.69Z" />
        </svg>
    );

    return (
        <>
            <SpinnerOverlay visible={isLoggingOut} />

            <Dialog.Confirm
                open={confirmLogout}
                onClose={() => setConfirmLogout(false)}
                title={'Sign Out'}
                confirm={'Sign Out'}
                onConfirmed={handleLogout}
            >
                Are you sure you want to sign out of your account?
            </Dialog.Confirm>

            {/* Mobile & Desktop Header Topbar */}
            <div
                className="light-topbar fixed top-0 right-0 h-16 bg-[#0f1423]/95 backdrop-blur-md border-b border-neutral-800 flex items-center justify-between px-4 md:px-6 z-40 left-0 md:left-64"
            >
                {/* Left Side: Mobile Hamburger button & Name */}
                <div css={tw`flex items-center`}>
                    <button
                        onClick={() => setSidebarOpen(!sidebarOpen)}
                        className="w-10 h-10 flex items-center justify-center rounded-lg bg-neutral-900 border border-neutral-800 text-neutral-200 hover:text-white mr-3 md:hidden focus:outline-none"
                    >
                        <FontAwesomeIcon icon={sidebarOpen ? faTimes : faBars} size="lg" />
                    </button>
                    <Link to="/" css={tw`text-lg font-header font-bold text-white tracking-tight truncate max-w-[120px] no-underline md:hidden`}>
                        {name}
                    </Link>
                </div>

                {/* Right Side: Grouped Boxed Icons */}
                <div css={tw`flex items-center space-x-2 flex-shrink-0`}>
                    {discordUrl && (
                        <a
                            href={discordUrl}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="w-10 h-10 flex items-center justify-center rounded-xl bg-[#121727] hover:bg-[#1a2238] border border-neutral-800 hover:border-purple-500/50 text-neutral-300 hover:text-purple-300 transition-all duration-200 shadow-md active:scale-95"
                            title="Join Discord"
                        >
                            <DiscordIcon />
                        </a>
                    )}
                    <div className="relative inline-flex items-center justify-center">
                        <button
                            type="button"
                            onClick={() => {
                                setNotificationOpen(true);
                                handleMarkAllRead();
                            }}
                            className="w-10 h-10 flex items-center justify-center rounded-xl bg-[#121727] hover:bg-[#1a2238] border border-neutral-800 hover:border-purple-500/50 text-neutral-300 hover:text-purple-300 transition-all duration-200 shadow-md active:scale-95 cursor-pointer focus:outline-none"
                            title="Notifications & Announcements"
                        >
                            <FontAwesomeIcon icon={faBell} size="lg" />
                        </button>
                        {unreadCount > 0 && (
                            <span className="absolute -top-1.5 -right-1.5 z-30 flex h-5 min-w-[20px] px-1 items-center justify-center rounded-full bg-gradient-to-r from-red-500 to-rose-600 text-[10px] font-black text-white shadow-lg border-2 border-[#0f1423] ring-1 ring-red-400/50 pointer-events-none animate-pulse">
                                {unreadCount > 9 ? '9+' : unreadCount}
                            </span>
                        )}
                    </div>
                    {isTicketsEnabled && (
                        <NavLink
                            to="/support"
                            className="w-10 h-10 flex items-center justify-center rounded-xl bg-[#121727] hover:bg-[#1a2238] border border-neutral-800 hover:border-purple-500/50 text-neutral-300 hover:text-purple-300 transition-all duration-200 shadow-md active:scale-95"
                            title="Support Tickets"
                        >
                            <FontAwesomeIcon icon={faHeadset} size="lg" />
                        </NavLink>
                    )}
                </div>
            </div>

            {/* Mobile Drawer Backdrop */}
            {sidebarOpen && (
                <div onClick={() => setSidebarOpen(false)} css={tw`fixed inset-0 bg-black bg-opacity-60 z-40 md:hidden`} />
            )}

            {/* Sidebar Navigation */}
            <div
                className={`fixed top-0 left-0 bottom-0 w-64 bg-[#0f1423]/95 backdrop-blur-md border-r border-neutral-800 flex flex-col z-50 transition-transform duration-200 ease-in-out theme-sidebar ${
                    sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'
                }`}
            >
                {/* Sidebar Header */}
                <div css={tw`flex items-center h-16 px-6 border-b border-neutral-800 bg-[#0c101a]`}>
                    <Link to="/" onClick={() => setSidebarOpen(false)} css={tw`text-xl font-header font-bold text-white tracking-tight truncate no-underline`}>
                        {name}
                    </Link>
                </div>


                {/* Navigation Links */}
                <div className="flex-1 overflow-y-auto px-3 py-4 space-y-1 custom-scrollbar">
                    <div className="text-[10px] font-bold text-neutral-500 px-4 pb-2 tracking-wider uppercase">
                        Global
                    </div>
                    <SidebarLink to="/" exact onClick={() => setSidebarOpen(false)}>
                        <FontAwesomeIcon icon={faLayerGroup} css={tw`w-5 mr-4 text-center`} />
                        <span>Dashboard</span>
                    </SidebarLink>

                    <SidebarLink to="/account" onClick={() => setSidebarOpen(false)}>
                        <FontAwesomeIcon icon={faUser} css={tw`w-5 mr-4 text-center`} />
                        <span>Account Settings</span>
                    </SidebarLink>

                    {location.pathname.startsWith('/account') && (
                        <div css={tw`pl-6 py-1 space-y-1`}>
                            {routes.account
                                .filter((route) => !!route.name)
                                .map((route) => {
                                    const path = `/account/${route.path}`.replace('//', '/').replace(/\/$/, '') || '/account';
                                    return (
                                        <SidebarLink
                                            key={route.path}
                                            to={path}
                                            exact={route.exact}
                                            onClick={() => setSidebarOpen(false)}
                                            css={tw`text-xs py-1.5 px-3`}
                                        >
                                            <span>{route.name}</span>
                                        </SidebarLink>
                                    );
                                })}
                        </div>
                    )}

                    <ServerSidebarLinks setSidebarOpen={setSidebarOpen} />

                    {rootAdmin && (
                        <>
                            <div className="h-px bg-neutral-800 my-4" />
                            <div className="text-[10px] font-bold text-neutral-500 px-4 pb-2 tracking-wider uppercase flex items-center justify-between">
                                <span>Administration</span>
                            </div>
                            <SidebarAnchor href="/admin" rel="noreferrer">
                                <FontAwesomeIcon icon={faCogs} css={tw`w-5 mr-4 text-center text-neutral-400`} />
                                <span>Admin Panel</span>
                            </SidebarAnchor>

                            {/* Ptero Plugins Accordion Section */}
                            <div className="mt-1">
                                <button
                                    type="button"
                                    onClick={() => setPluginsOpen(!pluginsOpen)}
                                    className="flex items-center justify-between w-full px-4 py-2.5 text-neutral-400 hover:text-white hover:bg-neutral-800/40 rounded-lg transition-all duration-200 text-left font-medium text-sm"
                                >
                                    <div className="flex items-center">
                                        <FontAwesomeIcon icon={faCubes} css={tw`w-5 mr-4 text-center text-purple-400 hover:text-purple-300 transition-colors`} />
                                        <span>Ptero Plugins</span>
                                    </div>
                                    <div className="flex items-center gap-2">
                                        <span className="text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-purple-600/30 text-purple-300 border border-purple-500/30">
                                            9
                                        </span>
                                        <FontAwesomeIcon
                                            icon={faChevronDown}
                                            className={`text-xs transition-transform duration-300 ${pluginsOpen ? 'rotate-180 text-purple-400' : 'text-neutral-500'}`}
                                        />
                                    </div>
                                </button>

                                <div
                                    className={`pl-5 pr-1 space-y-1 overflow-hidden transition-all duration-300 ease-in-out ${
                                        pluginsOpen ? 'max-h-96 opacity-100 py-1.5' : 'max-h-0 opacity-0'
                                    }`}
                                >
                                    <SidebarAnchor href="/admin/announcements" rel="noreferrer" css={tw`text-xs py-1.5 px-3 hover:text-pink-400`}>
                                        <FontAwesomeIcon icon={faBullhorn} css={tw`w-4 mr-3 text-pink-400`} />
                                        <span>Announcements</span>
                                    </SidebarAnchor>
                                    <SidebarAnchor href="/admin/theme" rel="noreferrer" css={tw`text-xs py-1.5 px-3 hover:text-cyan-400`}>
                                        <FontAwesomeIcon icon={faPaintBrush} css={tw`w-4 mr-3 text-cyan-400`} />
                                        <span>Theme Settings</span>
                                    </SidebarAnchor>
                                    <SidebarAnchor href="/admin/registration" rel="noreferrer" css={tw`text-xs py-1.5 px-3 hover:text-green-400`}>
                                        <FontAwesomeIcon icon={faUserPlus} css={tw`w-4 mr-3 text-green-400`} />
                                        <span>Register Config</span>
                                    </SidebarAnchor>
                                    <SidebarAnchor href="/admin/subdomains" rel="noreferrer" css={tw`text-xs py-1.5 px-3 hover:text-yellow-400`}>
                                        <FontAwesomeIcon icon={faLink} css={tw`w-4 mr-3 text-yellow-400`} />
                                        <span>Subdomains</span>
                                    </SidebarAnchor>
                                    <SidebarAnchor href="/admin/plugins" rel="noreferrer" css={tw`text-xs py-1.5 px-3 hover:text-purple-400`}>
                                        <FontAwesomeIcon icon={faPuzzlePiece} css={tw`w-4 mr-3 text-purple-400`} />
                                        <span>Plugins Downloader</span>
                                    </SidebarAnchor>
                                    <SidebarAnchor href="/admin/versions" rel="noreferrer" css={tw`text-xs py-1.5 px-3 hover:text-cyan-400`}>
                                        <FontAwesomeIcon icon={faDownload} css={tw`w-4 mr-3 text-cyan-400`} />
                                        <span>Versions Downloader</span>
                                    </SidebarAnchor>
                                    <SidebarAnchor href="/admin/tickets" rel="noreferrer" css={tw`text-xs py-1.5 px-3 hover:text-red-400`}>
                                        <FontAwesomeIcon icon={faTicketAlt} css={tw`w-4 mr-3 text-red-400`} />
                                        <span>Support Tickets</span>
                                    </SidebarAnchor>
                                    <SidebarAnchor href="/admin/tickets/config" rel="noreferrer" css={tw`text-xs py-1.5 px-3 hover:text-yellow-500`}>
                                        <FontAwesomeIcon icon={faWrench} css={tw`w-4 mr-3 text-yellow-500`} />
                                        <span>Tickets Config</span>
                                    </SidebarAnchor>
                                    <SidebarAnchor href="/admin/settings/backups" rel="noreferrer" css={tw`text-xs py-1.5 px-3 hover:text-blue-400`}>
                                        <FontAwesomeIcon icon={faCloudUploadAlt} css={tw`w-4 mr-3 text-blue-400`} />
                                        <span>Universal Backups</span>
                                    </SidebarAnchor>
                                </div>
                            </div>
                        </>
                    )}
                </div>

                {/* Sidebar Footer (Sign Out) */}
                <div css={tw`border-t border-neutral-800 p-3`}>
                    <SidebarButton onClick={onTriggerLogout}>
                        <FontAwesomeIcon icon={faSignOutAlt} css={tw`w-5 mr-4 text-center`} />
                        <span>Sign Out</span>
                    </SidebarButton>
                </div>
            </div>

            <NotificationDrawer
                open={notificationOpen}
                onClose={() => setNotificationOpen(false)}
                announcements={announcements}
            />
        </>
    );
};
