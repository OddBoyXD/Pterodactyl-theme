import React, { useEffect } from "react";
import { Announcement } from "@/api/getAnnouncements";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
    faBell,
    faBullhorn,
    faInfoCircle,
    faExclamationTriangle,
    faExclamationCircle,
    faTimes,
    faExternalLinkAlt,
    faCheckCircle,
} from "@fortawesome/free-solid-svg-icons";
import { formatDistanceToNow } from "date-fns";

interface Props {
    open: boolean;
    onClose: () => void;
    announcements: Announcement[];
}

export const NotificationDrawer: React.FC<Props> = ({
    open,
    onClose,
    announcements,
}) => {
    // Close on Escape key
    useEffect(() => {
        const handleKeyDown = (e: KeyboardEvent) => {
            if (e.key === "Escape" && open) {
                onClose();
            }
        };
        window.addEventListener("keydown", handleKeyDown);
        return () => window.removeEventListener("keydown", handleKeyDown);
    }, [open, onClose]);

    if (!open) {
        return null;
    }

    const list = Array.isArray(announcements) ? announcements : [];

    const getCategoryBadge = (category: string) => {
        switch (category) {
            case "update":
                return (
                    <span className="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 shadow-sm">
                        <FontAwesomeIcon icon={faBullhorn} className="mr-1.5 text-[10px]" />
                        Update
                    </span>
                );
            case "warning":
                return (
                    <span className="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-500/15 text-amber-300 border border-amber-500/30 shadow-sm">
                        <FontAwesomeIcon icon={faExclamationTriangle} className="mr-1.5 text-[10px]" />
                        Warning
                    </span>
                );
            case "danger":
                return (
                    <span className="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-rose-500/15 text-rose-300 border border-rose-500/30 shadow-sm">
                        <FontAwesomeIcon icon={faExclamationCircle} className="mr-1.5 text-[10px]" />
                        Critical
                    </span>
                );
            default:
                return (
                    <span className="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-purple-500/15 text-purple-300 border border-purple-500/30 shadow-sm">
                        <FontAwesomeIcon icon={faInfoCircle} className="mr-1.5 text-[10px]" />
                        Notice
                    </span>
                );
        }
    };

    return (
        <div className="fixed inset-0 z-50 overflow-hidden">
            {/* Backdrop with smooth blur */}
            <div
                className="fixed inset-0 bg-black/75 backdrop-blur-sm transition-opacity duration-300 cursor-pointer"
                onClick={onClose}
            />

            {/* Slide-over panel - 100% width on mobile, 440px on tablet/desktop */}
            <div className="fixed inset-y-0 right-0 max-w-full flex">
                <div className="w-screen max-w-full sm:max-w-md bg-[#0a0e1a]/98 backdrop-blur-2xl border-l border-neutral-800 text-neutral-200 shadow-2xl flex flex-col h-full animate-in slide-in-from-right duration-200">
                    {/* Header */}
                    <div className="p-4 sm:p-5 border-b border-neutral-800/80 bg-[#0f1424]/90 flex items-center justify-between">
                        <div className="flex items-center space-x-3">
                            <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-600/20 to-indigo-600/20 border border-purple-500/30 flex items-center justify-center text-purple-300 shadow-sm">
                                <FontAwesomeIcon icon={faBell} className="text-base" />
                            </div>
                            <div>
                                <h2 className="text-base font-bold text-white tracking-wide">
                                    Notifications & Updates
                                </h2>
                                <p className="text-xs text-neutral-400">
                                    {list.length} broadcast{list.length === 1 ? "" : "s"} total
                                </p>
                            </div>
                        </div>

                        <button
                            onClick={onClose}
                            className="w-9 h-9 rounded-xl bg-neutral-900 border border-neutral-800 text-neutral-400 hover:text-white hover:bg-neutral-800 hover:border-neutral-700 flex items-center justify-center transition-all duration-150 cursor-pointer"
                            title="Close"
                        >
                            <FontAwesomeIcon icon={faTimes} className="text-base" />
                        </button>
                    </div>

                    {/* Announcement Cards List */}
                    <div className="flex-1 overflow-y-auto p-3.5 sm:p-4 space-y-3">
                        {list.length === 0 ? (
                            <div className="h-64 flex flex-col items-center justify-center text-center p-6 text-neutral-500">
                                <div className="w-14 h-14 rounded-2xl bg-neutral-900/80 border border-neutral-800 flex items-center justify-center text-neutral-600 mb-3 shadow-inner">
                                    <FontAwesomeIcon icon={faCheckCircle} className="text-2xl text-purple-400" />
                                </div>
                                <h3 className="text-sm font-bold text-neutral-300">All caught up!</h3>
                                <p className="text-xs text-neutral-500 mt-1 max-w-xs">
                                    No announcements have been broadcasted yet. Check back later for platform updates!
                                </p>
                            </div>
                        ) : (
                            list.map((item) => {
                                let timeAgo = "Recently";
                                try {
                                    timeAgo = formatDistanceToNow(new Date(item.created_at), { addSuffix: true });
                                } catch (e) {
                                    // fallback
                                }

                                return (
                                    <div
                                        key={item.id}
                                        className="relative p-4 rounded-2xl bg-gradient-to-br from-[#12182b] to-[#0c101d] border border-neutral-800/80 hover:border-purple-500/40 shadow-lg hover:shadow-purple-950/20 transition-all duration-200"
                                    >
                                        <div className="flex items-center justify-between gap-2 mb-2">
                                            {getCategoryBadge(item.category)}
                                            <span className="text-[11px] font-medium text-neutral-400">
                                                {timeAgo}
                                            </span>
                                        </div>

                                        <h3 className="text-sm font-bold text-white mb-2 leading-snug">
                                            {item.title}
                                        </h3>

                                        <div
                                            className="text-xs text-neutral-300 leading-relaxed break-words mb-3 space-y-1"
                                            dangerouslySetInnerHTML={{ __html: item.content }}
                                        />

                                        {item.action_url && (
                                            <div className="pt-2 border-t border-neutral-800/60 mt-3">
                                                <a
                                                    href={item.action_url}
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    className="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-xs font-semibold shadow-md shadow-purple-950/30 transition-all duration-150 no-underline"
                                                >
                                                    <span>{item.action_text || "Learn More"}</span>
                                                    <FontAwesomeIcon icon={faExternalLinkAlt} className="text-[10px]" />
                                                </a>
                                            </div>
                                        )}
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
