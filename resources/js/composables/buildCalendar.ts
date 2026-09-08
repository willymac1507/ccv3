export function appointmentStatusClass(
    appointment: any,
    user: number,
    myDiary: boolean,
) {
    if (!myDiary && appointment.client !== user) {
        return 'bg-gray-500/10 text-gray-500/10';
    } else if (appointment.status === 'cancelled') {
        return 'bg-red-500/10 hover:bg-red-500/20 text-red-500';
    } else if (appointment.status === 'confirmed') {
        return 'bg-green-500/10 hover:bg-green-500/20 text-green-500';
    } else if (appointment.status === 'pending') {
        return 'bg-yellow-500/10 hover:bg-yellow-500/20 text-yellow-500';
    } else {
        return 'bg-blue-500/10 hover:bg-blue-500/20 text-blue-500';
    }
}

export function minutesFromTime(time: string) {
    const [hours, minutes] = time.split(':').map(Number);

    return hours * 60 + minutes;
}
export function rowForTime(
    time: string,
    calendarStart: number,
    interval: number,
) {
    const [hours, minutes] = time.split(':').map(Number);

    return (hours * 60 - calendarStart + minutes) / interval + 2;
}

export function createSlots(
    startTime: string,
    endTime: string,
    interval: number,
): Array<any> {
    const calendarStart = minutesFromTime(startTime);
    const calendarEnd = minutesFromTime(endTime);
    const result = [];

    for (let mins = calendarStart; mins < calendarEnd; mins += interval) {
        switch (mins % 60) {
            case 0:
                result.push({
                    label: `${String(Math.trunc(mins / 60)).padStart(2, '0')}:00`,
                    blocked: false,
                });
                break;
            case 15:
                result.push({
                    label: `${String(Math.trunc(mins / 60)).padStart(2, '0')}:15`,
                    blocked: false,
                });
                break;
            case 30:
                result.push({
                    label: `${String(Math.trunc(mins / 60)).padStart(2, '0')}:30`,
                    blocked: false,
                });
                break;
            case 45:
                result.push({
                    label: `${String(Math.trunc(mins / 60)).padStart(2, '0')}:45`,
                    blocked: false,
                });
                break;
            default:
                result.push('');
        }
    }

    return result;
}
