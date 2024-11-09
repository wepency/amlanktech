"use client";

import { formatTimeTo12Hour, formatToArabicDate } from "@/utils/formate-date";
import { Badge, Button } from "@mantine/core";
import { useSession } from "next-auth/react";
import axios from "axios";

import type {
  MeetingResponse,
  Meeting as MeetingType,
} from "@/types/meeting-response";

async function initClient({
                            meeting_id,
                            userEmail,
                            userName,
                            passcode,
                          }: MeetingType & { userName: string; userEmail: string }) {
  if (typeof window !== "undefined") {
    // Import ZoomMtg dynamically only in the browser environment
    const { ZoomMtg } = await import("@zoom/meetingsdk");
    ZoomMtg.preLoadWasm();
    ZoomMtg.prepareWebSDK();

    const signature = await getSignature({
      meetingNumber: meeting_id,
      role: 0,
    });

    document.getElementById("zmmtg-root")!.style.display = "block";
    const leaveURL = window.location.href;
    ZoomMtg.init({
      leaveUrl: leaveURL,
      patchJsMedia: true,
      success: (success: any) => {
        console.log(success);

        ZoomMtg.join({
          signature: signature,
          sdkKey: process.env.NEXT_PUBLIC_ZOOM_MEETING_CLIENT_ID,
          meetingNumber: meeting_id,
          passWord: passcode,
          userName: userName,
          userEmail: userEmail,
          success: (success: any) => {
            console.log(success);
          },
          error: (error: any) => {
            console.log(error);
          },
        });
      },
      error: (error: any) => {
        console.log(error);
      },
    });
  }
}

// Fetch signature from your auth endpoint
async function getSignature({
                              meetingNumber,
                              role,
                            }: {
  meetingNumber: string;
  role: 0 | 1;
}) {
  const response = await axios.post<{ signature: string }>(
      "/api/generate-meeting-signature",
      {
        meetingNumber: meetingNumber,
        role: role,
      },
      {
        headers: {
          "Content-Type": "application/json",
        },
      }
  );

  return response.data.signature;
}

export default function Meeting({ meeting }: { meeting: MeetingType }) {
  const { data: session } = useSession();

  const initZoomApp = async () => {
    await initClient({
      ...meeting,
      userName: session?.user?.name || "unknown",
      userEmail: session?.user?.email || "unknown",
    });
  };

  return (
      <div>
        <div id="zmmtg-root" className="z-50 mb-4"></div>

        <Button fullWidth disabled={!meeting.is_started} onClick={initZoomApp}>
          انضمام للاجتماع
        </Button>
        <div className="mt-4 flex items-center gap-2">
          <p className="mt-2 text-xs font-medium text-gray-500 sm:mt-0">
            {formatToArabicDate(meeting.start_time)}
          </p>
          <span className="hidden sm:block" aria-hidden="true">
          &middot;
        </span>
          <div className="flex items-center gap-1 text-gray-500">
            <svg
                className="h-4 w-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
            >
              <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
              ></path>
            </svg>

            <p className="text-xs font-medium">
              {formatTimeTo12Hour(meeting.start_time)}
            </p>
          </div>

          <span className="hidden sm:block" aria-hidden="true">
          &middot;
        </span>
          <p className="mt-2 text-xs font-medium text-gray-500 sm:mt-0">
            {meeting.current_users} في الانتظار
          </p>
          <span className="hidden sm:block" aria-hidden="true">
          &middot;
        </span>
          <div>
            <Badge
                color={meeting.is_started ? "green" : "violet"}
                variant="outline"
                size="sm"
            >
              {meeting.is_started ? "بدا" : " لم يبدأ بعد"}
            </Badge>
          </div>
        </div>
      </div>
  );
}