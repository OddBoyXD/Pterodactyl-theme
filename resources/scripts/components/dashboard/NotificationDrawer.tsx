import React, { useState } from "react";
import { Announcement } from "@/api/getAnnouncements";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
    faBell,
    faBullhorn,
    faInfoCircle,
    faExclamationTriangle,
    faExclamationCircle,
    faCheckDouble,
    faTimes,
    faExternalLinkAlt,
    faCheck,
} from "@fortawesome/free-solid-svg-icons";
import { formatDistanceToNow } from "date-fns";

interface Props {
    open: boolean;
    onClose: () => void;
    announcements: Announcement[];
    readIds: number[];
    onMarkAllRead: () => void;
    onMarkRead: (id: number) => void;
}

export const NotificationDrawer: React.FC<Props> = ({
    open,
    onClose,
    announcements,
    readIds,
    onMarkAllRead,
    onMarkRead,
}) => {
    const [filter, setFilter] = useState<"all" | "unread">("all");

    if (!open) {
        return null;
    }

    const list = Array.isArray(announcements) ? announcements : [];
    const safeReadIds = Array.isArray(readIds) ? readIds : [];
    const unreadCount = list.filter((a) => !safeReadIds.includes(a.id)).length;
    const displayed = filter === "unread" ? list.filter((a) => !safeReadIds.includes(a.id)) : list;

    const getCategoryBadge = (category: string) => {
        switch (category) {
            case "update":
                return (
                    <span className="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        <FontAwesomeIcon icon={faBullhorn} className="mr-1 text-[10px]" />
                        Update
                    </span>
                );
            case "warning":
                return (
                    <span className="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                        <FontAwesomeIcon icon={faExclamationTriangle} className="mr-1 text-[10px]" />
                        Warning
                    </span>
                );
            case "danger":
                return (
                    <span className="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">
                        <FontAwesomeIcon icon={faExclamationCircle} className="mr-1 text-[10px]" />
                        Alert
                    </span>
                );
            default:
                return (
                    <span className="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-purple-500/10 text-purple-400 border border-purple-500/20">
                        <FontAwesomeIcon icon={faInfoCircle} className="mr-1 text-[10px]" />
                        Notice
                    </span>
                );
        }
    };

    return (
        <div className="fixed inset-0 z-50 overflow-hidden">
            {/* Backdrop */}
            <div
                className="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity duration-300"
                onClick={onClose}
            />

            <div className="fixed inset-y-0 right-0 max-w-full flex pl-10">
                <div className="w-screen max-w-md bg-[#0c101a] border-l border-neutral-800 text-neutral-200 shadow-2xl flex flex-col">
                    {/* Header */}
                    <div className="p-5 border-b border-neutral-800 bg-[#0f1423]/95 flex items-center justify-between">
                        <div className="flex items-center space-x-3">
                            <div className="w-9 h-9 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 shadow-sm">
                                <FontAwesomeIcon icon={faBell} className="text-sm" />
                            </div>
                            <div>
                                <h2 className="text-base font-bold text-white tracking-wide flex items-center gap-2">
                                    Notifications
                                    {unreadCount > 0 && (
                                        <span className="px-2 py-0.5 text-xs font-bold rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                                            {unreadCount} new
                                        </span>
                                    )}
                                </h2>
                                <p className="text-xs text-neutral-400">Broadcasts & platform updates</p>
                            </div>
                        </div>

                        <div className="flex items-center space-x-2">
                            {unreadCount > 0 && (
                                <button
                                    onClick={onMarkAllRead}
                                    className="px-2.5 py-1 text-xs font-semibold text-purple-400 hover:text-purple-300 bg-purple-500/10 hover:bg-purple-500/20 border border-purple-500/20 rounded-lg transition-all duration-150 flex items-center gap-1.5"
                                    title="Mark all as read"
                                >
                                    <FontAwesomeIcon icon={faCheckDouble} className="text-[11px]" />
                                    <span>Read all</span>
                                </button>
                            )}
                            <button
                                onClick={onClose}
                                className="w-8 h-8 rounded-lg flex items-center justify-center text-neutral-400 hover:text-white hover:bg-neutral-800/80 transition-colors"
                            >
                                <FontAwesomeIcon icon={faTimes} />
                            </button>
                        </div>
                    </div>

                    {/* Filter Tabs */}
                    <div className="px-5 py-3 border-b border-neutral-800/80 bg-neutral-900/40 flex items-center space-x-2">
                        <button
                            onClick={() => setFilter("all")}
                            className={`px-3 py-1.5 rounded-lg text-xs font-medium transition-all ${
                                filter === "all"
                                    ? "bg-purple-600 text-white shadow-sm font-semibold"
                                    : "text-neutral-400 hover:text-white hover:bg-neutral-800"
                            }`}
                        >
                            All ({list.length})
                        </button>
                        <button
                            onClick={() => setFilter("unread")}
                            className={`px-3 py-1.5 rounded-lg text-xs font-medium transition-all ${
                                filter === "unread"
                                    ? "bg-purple-600 text-white shadow-sm font-semibold"
                                    : "text-neutral-400 hover:text-white hover:bg-neutral-800"
                            }`}
                        >
                            Unread ({unreadCount})
                        </button>
                    </div>

                    {/* Notifications List */}
                    <div className="flex-1 overflow-y-auto p-4 space-y-3">
                        {displayed.length === 0 ? (
                            <div className="h-64 flex flex-col items-center justify-center text-center p-6 text-neutral-500">
                                <div className="w-12 h-12 rounded-2xl bg-neutral-900 border border-neutral-800 flex items-center justify-center text-neutral-600 mb-3">
                                    <FontAwesomeIcon icon={faBell} className="text-xl" />
                                </div>
                                <p className="text-sm font-medium text-neutral-400">
                                    {filter === "unread" ? "No unread notifications" : "No notifications yet"}
                                </p>
                                <p className="text-xs text-neutral-600 mt-1">You are completely up to date!</p>
                            </div>
                        ) : (
                            displayed.map((item) => {
                                const isUnread = !readIds.includes(item.id);
                                let timeAgo = "Just now";
                                try {
                                    timeAgo = formatDistanceToNow(new Date(item.created_at), { addSuffix: true });
                                } catch (e) {
                                    // fallback
                                }

                                return (
                                    <div
                                        key={item.id}
                                        className={`relative p-4 rounded-xl border transition-all duration-200 ${
                                            isUnread
                                                ? "bg-gradient-to-br from-[#121829] to-[#0d1220] border-purple-900/40 shadow-md"
                                                : "bg-[#0f1422]/60 border-neutral-800/80 opacity-80 hover:opacity-100"
                                        }`}
                                    >
                                        {/* Unread Glowing Dot */}
                                        {isUnread && (
                                            <span className="absolute top-4 right-4 flex h-2.5 w-2.5">
                                                <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                                                <span className="relative inline-flex rounded-full h-2.5 w-2.5 bg-purple-500"></span>
                                            </span>
                                        )}

                                        <div className="flex items-center space-x-2 mb-2">
                                            {getCategoryBadge(item.category)}
                                            <span className="text-[11px] text-neutral-400">{timeAgo}</span>
                                        </div>

                                        <h3 className="text-sm font-bold text-white mb-1.5 leading-snug pr-4">
                                            {item.title}
                                        </h3>

                                        <div
                                            className="text-xs text-neutral-300 leading-relaxed break-words mb-3"
                                            dangerouslySetInnerHTML={{ __html: item.content }}
                                        />

                                        <div className="flex items-center justify-between pt-2 border-t border-neutral-800/60 mt-2">
                                            {item.action_url ? (
                                                <a
                                                    href={item.action_url}
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    className="inline-flex items-center text-xs font-semibold text-purple-400 hover:text-purple-300 transition-colors"
                                                >
                                                    {item.action_text || "Learn More"}
                                                    <FontAwesomeIcon icon={faExternalLinkAlt} className="ml-1 text-[10px]" />
                                                </a>
                                            ) : (
                                                <div />
                                            )}

                                            {isUnread && (
                                                <button
                                                    onClick={() => onMarkRead(item.id)}
                                                    className="text-[11px] font-medium text-neutral-400 hover:text-purple-300 flex items-center gap-1 transition-colors"
                                                >
                                                    <FontAwesomeIcon icon={faCheck} className="text-[10px]" />
                                                    Mark read
                                                </button>
                                            )}
                                        </div>
                                    </div>
                                );
                            })
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default NotificationDrawer;
