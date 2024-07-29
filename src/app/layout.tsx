// Import styles of packages that you've installed.
// All packages except `@mantine/hooks` require styles imports
import "./preflight.css"
import "@mantine/core/styles.css"
import "./globals.css"
import "@mantine/notifications/styles.css"

import { Cairo } from "next/font/google"
import {
  ColorSchemeScript,
  createTheme,
  DirectionProvider,
  MantineColorsTuple,
  MantineProvider,
} from "@mantine/core"
import { ModalsProvider } from "@mantine/modals"
import { Notifications } from "@mantine/notifications"
import { ReactQueryDevtools } from "@tanstack/react-query-devtools"

import MyReactQueryProvider from "@/lib/react-query/providers"

const primaryColor: MantineColorsTuple = [
  "#ebf8ff",
  "#d6edfa",
  "#a7daf8",
  "#77c7f6",
  "#55b6f5",
  "#44abf5",
  "#3ba6f6",
  "#2f91db",
  "#2382c4",
  "#006fad",
]

const theme = createTheme({
  colors: {
    primaryColor,
  },
  primaryColor: "primaryColor",
})

export const metadata = {
  title: "Amlack",
  description:
    "منصة املاك تك هي منصة سعودية تهدف الى رقمنة التجمعات العقارية لتدعم التحول الرقمي في القطاع الرقمي اعتمادا على علوم البيانات والذكاء الاصطناعي لتعزيز المصداقية والشفافية لملاك التجمعات العقارية.",
}
const cairo = Cairo({ subsets: ["latin"], weight: ["400", "500", "700"] })

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="ar" dir="rtl">
      <head>
        <ColorSchemeScript />
      </head>
      <body className={cairo.className + " relative bg-[#fafafa]"}>
        <DirectionProvider initialDirection="rtl">
          <MantineProvider theme={theme}>
            <MyReactQueryProvider>
              <Notifications />
              <ModalsProvider>{children}</ModalsProvider>
              <ReactQueryDevtools initialIsOpen={false} />
            </MyReactQueryProvider>
          </MantineProvider>
        </DirectionProvider>
      </body>
    </html>
  )
}
