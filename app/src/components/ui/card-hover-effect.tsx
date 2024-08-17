"use client"

import { useState } from "react"
import Image, { StaticImageData } from "next/image"
import { cn } from "@/utils/cn"
import { AnimatePresence, motion } from "framer-motion"

export const HoverEffect = ({
  items,
  className,
}: {
  items: {
    title: string
    description: string
    src: StaticImageData
  }[]
  className?: string
}) => {
  let [hoveredIndex, setHoveredIndex] = useState<number | null>(null)

  return (
    <div
      className={cn(
        "grid grid-cols-1 py-10  md:grid-cols-2  lg:grid-cols-3",
        className,
      )}>
      {items.map((item, idx) => (
        <div
          key={`${idx}-${item.title}`}
          className="group relative  block h-full w-full p-2"
          onMouseEnter={() => setHoveredIndex(idx)}
          onMouseLeave={() => setHoveredIndex(null)}>
          <AnimatePresence>
            {hoveredIndex === idx && (
              <motion.span
                className="absolute inset-0 block h-full w-full rounded-3xl bg-neutral-200  "
                layoutId="hoverBackground"
                initial={{ opacity: 0 }}
                animate={{
                  opacity: 1,
                  transition: { duration: 0.15 },
                }}
                exit={{
                  opacity: 0,
                  transition: { duration: 0.15, delay: 0.2 },
                }}
              />
            )}
          </AnimatePresence>
          <Card>
            <CardImage src={item.src} />
            <CardTitle className="text-center">{item.title}</CardTitle>
            <CardDescription className="text-center">
              {item.description}
            </CardDescription>
          </Card>
        </div>
      ))}
    </div>
  )
}

export const Card = ({
  className,
  children,
}: {
  className?: string
  children: React.ReactNode
}) => {
  return (
    <div
      className={cn(
        "relative z-20 h-full w-full overflow-hidden rounded-2xl border border-transparent  p-4 ",
        className,
      )}>
      <div className="relative z-50">
        <div className="p-4">{children}</div>
      </div>
    </div>
  )
}
export const CardImage = ({
  className,
  src,
}: {
  className?: string
  src: StaticImageData
}) => {
  return (
    <div className="mb-8">
      <Image
        src={src}
        className=" mx-auto aspect-square w-full max-w-[85px] rounded"
        alt="card icon"
      />
    </div>
  )
}
export const CardTitle = ({
  className,
  children,
}: {
  className?: string
  children: React.ReactNode
}) => {
  return (
    <h4 className={cn("mt-4 font-bold tracking-wide text-Gray", className)}>
      {children}
    </h4>
  )
}
export const CardDescription = ({
  className,
  children,
}: {
  className?: string
  children: React.ReactNode
}) => {
  return (
    <p
      className={cn(
        "mt-3 text-sm leading-relaxed tracking-wide text-zinc-600",
        className,
      )}>
      {children}
    </p>
  )
}
