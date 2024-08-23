type Format = "long" | "court";

export const formatMessageDate = (dateToFormat: string, format: Format = "court"): string => {
    const now = new Date();
    const date = new Date(dateToFormat);

    if (isSameDay(date, now)) {
        return formatTime(date);
    } else if (isSameDay(date, getYesterday())) {
        return format === "court" ? "Hier" : `Hier à ${formatTime(date)}`;
    } else if (date.getFullYear() === now.getFullYear()) {
        return `${formatDate(date)} à ${formatTime(date)}`;
    } else {
        return date.toLocaleDateString();
    }
};

const isSameDay = (date1: Date, date2: Date): boolean => {
    return (
        date1.getDate() === date2.getDate() &&
        date1.getMonth() === date2.getMonth() &&
        date1.getFullYear() === date2.getFullYear()
    );
};

const getYesterday = (): Date => {
    const yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    return yesterday;
};

const formatTime = (date: Date): string => {
    return date.toLocaleTimeString([], {
        hour: "2-digit",
        minute: "2-digit",
    });
};

const formatDate = (date: Date): string => {
    return date.toLocaleDateString([], {
        day: "2-digit",
        month: "short",
    });
};
