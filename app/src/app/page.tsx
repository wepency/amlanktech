import { Suspense } from "react"
import {
  advantage,
  building,
  contract,
  conversation,
  management,
  work,
} from "@/assets"
import { Loader } from "@mantine/core"

import { HoverEffect } from "@/components/ui/card-hover-effect"
import Footer from "@/components/landing-page/footer"
import { GetInTouch } from "@/components/landing-page/get-in-touch"
import { Header } from "@/components/landing-page/header"
import { HeroSection } from "@/components/landing-page/hero"
import Partners from "@/components/landing-page/partners"
import Pricing from "@/components/landing-page/pricing"
import Status from "@/components/landing-page/status"
import ZoomFeature from "@/components/landing-page/zoom-feature"

const projects = [
  {
    title: "إدارة العقارات والمرافق",
    src: building,
    description:
      "تحول رقميًا بأتمتة جميع عمليات إدارة وتشغيل الأملاك والمرافق العقارية بحلول تقنية متكاملة تعزز من استدامة أعمالك وتسرعها، وتزيد من كفائتك وتخفض تكالفيك إلى النصف.",
  },
  {
    title: "طلبات صيانة آلية",
    src: management,
    description:
      "قم بإجراء طلبات الصيانة العقارية آليًا، وتابع إنجازها في وقت قياسي بعد بإسنادها للمختصين (موظفين –مقاولين) مع ضمان تنفيذ طلب الصيانة برمز تأكيد الجودة.",
  },
  {
    title: "توثيق المعاملات المالية بين التجعات العقارية  ",
    src: contract,
    description: `Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae soluta placeat, fugit cupiditate, modi distinctio obcaecati quos, vel beatae quisquam doloribus? Cumque impedit sit blanditiis cum facilis maiores consequatur qui?`,
  },
  {
    title: "إدارة العقود والمستحقات المالية",
    src: work,
    description: `Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae soluta placeat, fugit cupiditate, modi distinctio obcaecati quos, vel beatae quisquam doloribus? Cumque impedit sit blanditiis cum facilis maiores consequatur qui?`,

    // description:
    // "احصل على أفضل برنامج حسابات سحابي مخصص لإدارة الأملاك العقارية ، ينشئ النظام قيود يومية آلية ويدعم مختلف العمليات والتقارير المحاسبية لتوفير وقت وجهد طاقمك المحاسبي.",
  },
  {
    title: "إدارة محاضر مجالس ادارات التجمعات العقارية",
    src: conversation,
    description:
      ".حدول اجتمعاتك وناقش اخر التطورات مع اعضاء جمعيتك مباشرة عبر منصتنا",
  },
  {
    title: "طرح المنافسات للتجمع العقاري",
    src: advantage,
    description: `Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae soluta placeat, fugit cupiditate, modi distinctio obcaecati quos, vel beatae quisquam doloribus? Cumque impedit sit blanditiis cum facilis maiores consequatur qui?`,
  },
]

export const revalidate = 300
export default async function Home() {
  return (
    <>
      <Header />
      <HeroSection />
      <section className=" bg-slate-50">
        <div className="container py-14">
          <HoverEffect items={projects} />
        </div>
      </section>
      <ZoomFeature />
      <Status />
      <Partners />
      <Suspense
        fallback={
          <div className="flex h-screen items-center justify-center">
            <Loader size={"lg"} />
          </div>
        }>
        <Pricing />
      </Suspense>
      <section id="contact-us">
        <div className="container py-14">
          <GetInTouch />
        </div>
      </section>
      <Footer />
    </>
  )
}
